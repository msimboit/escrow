<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Deliveries;
use App\Tdetails;
use App\RejectDelivery;
use App\Jobs\Sms;
use DB;
use Auth;
use Log;

use Twilio\Rest\Client;

class RejectDeliveryController extends Controller
{
    public function index()
    {
        $rejections = RejectDelivery::where('resolved', '0')->get();
        // dd($rejections);
        return view('Delivery.rejections', compact('rejections'));
    }

    public function show($id) 
    {
        $rejection = RejectDelivery::where('id', $id)->first();
        // dd($rejection);
        return view('Delivery.rejectionInfo', compact('rejection'));
    }

    public function getOrder($id) 
    {
        $rejection = RejectDelivery::where('id', $id)->first();
        // dd($rejection);
        
        $arr = Tdetails::where('id', $rejection->orderId)->first();
    
        $vdetails = User::where('id', $arr->vendor_id)->first();
        
        $cdetails = User::where('phone_number', $arr->client_phone)->first();

        $itemdesc = explode(". ", $arr->transdetail);
        $quantities = explode(" ", $arr->deposited);
        $prices = explode(" ", $arr->transamount);
        $product_image = explode(" & ", $arr->product_image);
        $total_amount = (array_sum($prices)) + ($arr->deliveryamount);
        
        $collection = collect($itemdesc);

        $combined = $collection->combine($prices);

        $tariff = 0;

        if($t >= 1 && $t <= 100)
        {
            $tariff = 28;
        }

        if($total_amount >= 101 && $total_amount <= 499)
        {
            $tariff = 83;
        }

        if($total_amount >= 500 && $total_amount <= 999)
        {
            $tariff = 89;
        }

        if($total_amount >= 1000 && $total_amount <= 1499)
        {
            $tariff = 105;
        }

        if($total_amount >= 1500 && $total_amount <= 2499)
        {
            $tariff = 110;
        }

        if($total_amount >= 2500 && $total_amount <= 3499)
        {
            $tariff = 159;
        }

        if($total_amount >= 3500 && $total_amount <= 4999)
        {
            $tariff = 181;
        }

        if($total_amount >= 5000 && $total_amount <= 7499)
        {
            $tariff = 232;
        }

        if($total_amount >= 7500 && $total_amount <= 9999)
        {
            $tariff = 265;
        }

        if($total_amount >= 10000 && $total_amount <= 14999)
        {
            $tariff = 347;
        }

        if($total_amount >= 15000 && $total_amount <= 19999)
        {
            $tariff = 370;
        }

        if($total_amount >= 20000 && $total_amount <= 24999)
        {
            $tariff = 386;
        }

        if($total_amount >= 25000 && $total_amount <= 29999)
        {
            $tariff = 391;
        }

        if($total_amount >= 30000 && $total_amount <= 34999)
        {
            $tariff = 396;
        }

        if($total_amount >= 35000 && $total_amount <= 39999)
        {
            $tariff = 570;
        }

        if($total_amount >= 40000 && $total_amount <= 44999)
        {
            $tariff = 575;
        }

        if($total_amount >= 45000 && $total_amount <= 49999)
        {
            $tariff = 580;
        }

        if($total_amount >= 50000 && $total_amount <= 69999)
        {
            $tariff = 623;
        }

        if($total_amount >= 70000 && $total_amount <= 150000)
        {
            $tariff = 628;
        }

        return view('Delivery.flaggedOrder', compact('arr', 'vdetails', 'cdetails', 'itemdesc', 'product_image', 'quantities', 'prices', 'tariff',  'combined'))->with($rejection->orderId);
    }

    public function clearRejection($id) 
    {
        $rejection = RejectDelivery::where('id', $id)
                        ->update([
                                    'resolved' => '1',                                                             
                            ]);
        
        return redirect()->route('rejections')->with('success', 'Rejection Has Been Resolved');
    }

    public function rejectDelivery(Request $request)
    {

        RejectDelivery::create([
            'title' => $request->title,
            'details' => $request->details,
            'clientName' => $request->clientName,
            'clientNumber' => $request->clientNumber,
            'clientEmail' => $request->clientEmail,
            'vendorName' => $request->vendorName,
            'vendorNumber' => $request->vendorNumber,
            'vendorEmail' => $request->vendorEmail,
            'orderId' => $request->orderId,
            'orderdate' => $request->orderdate,
            'transdetail' => $request->transdetail,
            'quantity' => $request->quantity,
            'subtotal' => $request->subtotal,
            'tariff' => $request->tariff,
            'total' => $request->total,
            'deliveryfee' => $request->deliveryfee,
        ]);

        Tdetails::where('id', $request->orderId)
                        ->update(['suspended' => 1]);

        $vendor = User::where('phone_number', $request->vendorNumber)->first();

        $phone_number = $request->vendorNumber;
        $phone_number = substr($phone_number, -9);
        $phone_number = '0'.$phone_number;
        $message = 'Dear'.$vendor->business_name.', please note that '.$request->clientName.' has rejected the goods for the Order ID'.$request->orderId.'. Please contact the buyer on the number '. $request->clientNumber.'to resolve the issue.';
        $SID = 'DEPTHSMS';
        Sms::dispatch($phone_number, $message, $SID )->onQueue('sms');

        $phone_number = $request->vendorNumber;
        $phone_number = substr($phone_number, -9);
        $phone_number = '0'.$phone_number;
        $message = 'Dear'.$request->clientName.', you have rejected a delivery from the vendor '.$vendor->business_name.' on the Order ID'.$request->orderId.'. We will refund you for the transaction amount withholding the handling fee. Please contact the vendor on the number '. $vendor->phone_number .' if you wish to resolve the issue.';
        $SID = 'DEPTHSMS';
        Sms::dispatch($phone_number, $message, $SID )->onQueue('sms');

        return redirect()->route('deliveries')->with('success', 'Report Has Been Sent');

    }

    /**
     * Twilio sms
     */

    public function send_sms($recipient, $message)
    {

        // // Your Account SID and Auth Token from twilio.com/console
        // $account_sid = 'AC3261703f9f12fe402d7c164af1e0834b';
        // $auth_token = '016ca55f0efd7b4494d5f2fb6467788a';
        // In production, these should be environment variables. E.g.:
        $account_sid = $_ENV["TWILIO_AUTH_SID"];
        $auth_token = $_ENV["TWILIO_AUTH_TOKEN"];

        // A Twilio number you own with SMS capabilities
        $twilio_number = "+19362460202";
        // $recipient = '+254704618977';
        // $message = "Escrow sent this message";

        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            $recipient,
            array(
                'from' => $twilio_number,
                'body' => $message
            )
        );
    }

    /**
     * UjumbeSMS Functions start here
     */
    public function prepare($data)
    {

        $data = [
            "data" => [[
                "message_bag" => [
                    "numbers" => $data['numbers'],
                    "message" => $data['message'],
                    "sender" => $data['sender'],
                ]
            ]]
        ];

        Log::info($data);

        $sms_data = json_encode($data);
        $url = 'https://ujumbesms.co.ke/api/messaging';

        Log::info($sms_data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $sms_data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($sms_data),
            'X-Authorization: ZTQ1ZGIwNjFkMGFhZDQyOTQ3OTBmYTYyMGJlYjYy',
            'email: abraham.nyabera@msimboit.net'
        ));


        $response = curl_exec($curl);
        Log::info($response);

        if ($response === false) {
            $err = 'Curl error: ' . curl_error($curl);
            curl_close($curl);
            Log::info($err);
            return $err;
        } else {
            curl_close($curl);
            Log::info($response);
            return $response;
        }
    }

    /**
     * @param $numbers = phone numbers separated with commas
     * @param $message
     * @param $sender = The sender id assigned by ujumbeSMS eg DepthSMS
     */
    public function send($numbers, $message, $sender)
    {

        $data = [
            "numbers" => $numbers,
            "message" => $message,
            "sender" => $sender
        ];
        $this->prepare($data);

    }
}
