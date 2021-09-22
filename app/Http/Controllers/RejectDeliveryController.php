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

        $recipient = $request->vendorNumber;
        $recipient = substr($recipient, -9);
        $recipient = '+254' . $recipient;
        $message = 'A rejection of goods has occured for the order of: "'.$request->transdetail.'" by '.$request->clientName.'. The complaint was: '.$request->details;
        $this->send_sms($recipient, $message);    

        return redirect()->route('deliveries')->with('success', 'Report Has Been Sent');

    }

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
}
