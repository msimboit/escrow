<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\DeliveryMail;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Deliveries;
use App\Tdetails;
use App\Clients;
use DB;
use Auth;

use Twilio\Rest\Client;



class DeliveryController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $deliveries = Tdetails::where('paid', '1')->orderBy('created_at', 'desc')->paginate(100)->where('closed', '0');
        //dd($deliveries[0]);

        $vendors = User::where('role','vendor')->get();

        $clients = User::where('role','client')->get();

        //dd($deliveries[0]);
    
        return view('Delivery.index', compact('deliveries','vendors','clients'));
    }

    public function create()
    {
        return view('Delivery.create');
    }

    public function show($id)
    {
        $arr = Tdetails::where('id', $id)->first();
        $vdetails = User::where('id', $arr->vendor_id)->first();
        $cdetails = User::where('id', $arr->client_id)->first();
        $itemdesc = explode(". ", $arr->transdetail);
        $quantities = explode(" ", $arr->deposited);
        $prices = explode(" ", $arr->transamount);
        $product_image = explode(" & ", $arr->product_image);

        $total_amount = (array_sum($prices)) + ($arr->deliveryamount);


        $collection = collect($itemdesc);
        $combined = $collection->combine($prices);

        // dd($combined);

        $tariff = 0;

        if($total_amount >= 1 && $total_amount <= 100)
        {
            $tariff = 28;
        }

        if($total_amount >= 101 && $total_amount <= 499)
        {
            $tariff = 83;
        }

        if($total_amount >= 500 && $total_amount <=1000)
        {
            $tariff = 89;
        }

        if($total_amount >= 1001 && $total_amount <= 1499)
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

        // dd($tariff);

        return view('Delivery.show', compact('arr', 'vdetails', 'cdetails', 'itemdesc', 'product_image', 'quantities', 'prices', 'combined', 'tariff'))->with($id);
        //return $vdetails;
    }

    public function edit($id)
    {
        $deliveries = Deliveries::find($id);
        return view('Delivery.edit', compact('deliveries'));   
    }

    public function acceptDelivery(Request $request) 
    {
        // dd($request->all());

        if($request->has('acceptDelivery'))
        {
            
            if($request->itemCheckbox != null)
                {
                    $sum = array_sum($request->itemCheckbox);
                    // dd($sum);

                    //Doing a check if all items have been accepted or rejected then prompt the vendor accordingly
                    
                    if($request->subtotal == $sum)
                    {
                        // dd('Entire Delivery was accepted');
                        $update_tdetails_table = DB::table('tdetails')
                                    ->where('id', $request->input('orderId'))
                                    ->update([
                                    'delivered' => '1',
                                    'closed' => '1'                                                                 
                            ]);

                        $amount_due = ($request->subtotal) - $sum;

                        $update_payments_table = DB::table('payments')
                                    ->where('transactioncode', $request->input('orderId'))
                                    ->update([
                                    'amount_due' => $amount_due,                                                          
                                ]);

                        $transaction = Tdetails::where('id', $request->input('orderId'))
                                        ->first();

                        $email = Auth::user()->email;
                        // dd($transaction);
                        $vendor = User::where('id', $transaction->vendor_id)->first();
                        
                        $client = User::where('id', $transaction->client_id)->first();

                        $data = [
                            'client_name' => $client->first_name,
                            'client_phone' => $client->phone_number,
                            'transaction_details' => $transaction->transdetail,
                            'delivery_location' => $transaction->deliverylocation,
                            'delivery_time' => $transaction->deliverytime,
                            'delivery_fee' => $transaction->deliveryamount,
                            'delivery_fee_handler' => $transaction->delivery_fee_handler,
                        ];
                        // Mail::to($email)->send(new DeliveryMail($data));
                        
                        return redirect()->route('deliveries')->with('success', 'Delivery Confirmed');

                    } else{
                            // dd('Entire Delivery was not accepted');
                            $trans_details = $request->all();

                            $update_tdetails_table = DB::table('tdetails')
                                        ->where('id', $request->input('orderId'))
                                        ->update([
                                        'delivered' => '1',
                                        'closed' => '1'                                                                 
                                ]);

                            $amount_due = ($request->subtotal) - $sum;
                            // dd($amount_due);

                            $update_payments_table = DB::table('payments')
                                        ->where('transactioncode', $request->input('orderId'))
                                        ->update([
                                        'amount_due' => $amount_due,                                                          
                                    ]);

                            $transaction = Tdetails::where('id', $request->input('orderId'))
                                            ->first();

                            $email = Auth::user()->email;
                            // dd($transaction);
                            $vendor = User::where('id', $transaction->vendor_id)->first();
                            
                            $client = User::where('id', $transaction->client_id)->first();

                            $data = [
                                'client_name' => $client->first_name,
                                'client_phone' => $client->phone_number,
                                'transaction_details' => $transaction->transdetail,
                                'delivery_location' => $transaction->deliverylocation,
                                'delivery_time' => $transaction->deliverytime,
                                'delivery_fee' => $transaction->deliveryamount,
                                'delivery_fee_handler' => $transaction->delivery_fee_handler,
                            ];
                            // Mail::to($email)->send(new DeliveryMail($data));
                            
                            return view('Delivery.rejectDelivery', compact('trans_details'))->with('alertMsg', 'Not all purchases were accepted upon delivery');
                    }
                    
                }
                else{
                    return redirect()->back()->with('alert', 'Accept at least one or all deliveries using the accept checkboxes!');
                }
        }

        if($request->has('rejectDelivery')) 
        {
            $trans_details = $request->all();
            // dd($trans_details);
            return view('Delivery.rejectDelivery', compact('trans_details'));
        }
        
    }

    public function rejectDelivery(Request $request) 
    {
        dd($request->all());

        
        
        return redirect()->route('deliveries')->with('success', 'Delivery Confirmed');
    }

    public function destroy($id)
    {

        $client = Deliveries::find($id);
        $client->delete();

        return redirect()->route('deliveries')->with('success', 'Deliery deleted!');
    }


    public function search(Request $request)
    {
        //dd($request->q);
        $search = Tdetails::where('client_phone', 'like', "%{$request->q}%")
            ->where('vendor_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $phone = $request->q;
        return view('Delivery.search', ['search' => $search, 'phone' => $phone]);
    }

    /**
     * Sending SMS via Twilio
     * 
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
}
