<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Deliveries;
use App\Tdetails;
use App\RejectDelivery;
use DB;
use Auth;

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

        // $recipient = $request->vendorNumber;
        // $recipient = substr($recipient, -9);
        // $recipient = '+254' . $recipient;
        // $message = 'A rejection of goods has occured for the order of: "'.$request->transdetail.'" by '.$request->clientName.'. The complaint was: '.$request->details;
        // $this->send_sms($recipient, $message);   
        
        $number = $request->vendorNumber;
        $number = substr($number, -9);
        $number = '0'.$number;
        $message = 'A rejection of goods has occured for the order of: "'.$request->transdetail.'" by '.$request->clientName.'. The complaint was: '.$request->details;
        $this->send($number, $message, "DEPTHSMS");

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
