<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ThankyouMail;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Tdetails;
use App\Vendors;
use App\Clients;
use App\Product;
use App\mpesa_token;
use Auth;
use Log;
use DB;

use Twilio\Rest\Client;



class TransactionController extends Controller
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
        $transactions = Tdetails::where('paid', 0)->orderBy('created_at', 'desc')->paginate(100);
        $vendors = User::where('role','vendor')->get();
        $clients = User::where('role','client')->get();
        //dd($transactions);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
            //From Supamall
            // $vendors = DB::table('ad_supamalluser')->select('name')->pluck('name');
            // // $vendors = DB::table('ad_supamallproduct') ->select('id','user_id', 'product_name','phone')
            // // ->get();

            $vendors = User::where('role', 'vendor')->get();
            // $clients = User::where('role', 'client')->get();
            $clients = User::where('role' ,'!=', 'admin')
                        ->orderBy('first_name', 'asc')
                        ->get();
            /*
            $prds = Product::all(); //('name','id');
            */
            $prds = DB::table('ad_supamallproduct') ->select('id','user_id', 'product_name', 'price', 'phone')
            ->get();
            $selectedID = 2;
            //dd($vendors);
            return view('transactions.create', compact('vendors','clients','prds'));

            //return ($vendors);
    
    }

    public function show($id)
    {
        $arr = Tdetails::where('id', $id)->first();
    
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

        if($total_amount >= 1 && $total_amount < 50)
        {
            $tariff = 3;
        }

        if($total_amount >= 50 && $total_amount <= 100)
        {
            $tariff = 13;
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

        // dd($tariff);
        return view('transactions.show', compact('arr', 'vdetails', 'cdetails', 'itemdesc', 'product_image', 'quantities', 'prices', 'tariff',  'combined'))->with($id);
    }

    public function edit($id)
    {
        // $items = Vendors::pluck('firstname', 'id');
        // $clients = Clients::pluck('firstname', 'id');
        // $prds = Product::all();
        // $selectedID = 2;

        // $trans = Tdetails::where('id', $id)->first();
        // return view('transactions.edit', compact('trans','items','clients','prds'))->with($id);

        $trans = Tdetails::where('id', $id)->first();
        $vendors = User::where('id', $trans->vendor_id)->get();
        $clients = User::where('role' ,'!=', 'admin')
                        ->orderBy('first_name', 'asc')
                        ->get();
        $client = User::where('id' , $trans->client_id)->get();

        return view('transactions.edit1', compact('vendors','clients', 'client', 'trans'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'client_id' => 'required',
            'itemdesc' => 'required',
            'quantities' => 'required',
            'prices' => 'required',
            'location' => 'required',
            'deliveryfee' => 'required'
        ]);

        // dd($request->all());
        $itemdesc = implode (". ", $request->input('itemdesc',[]));
        $quantities = implode (" ", $request->input('quantities',[]));
        $prices = implode (" ", $request->input('prices',[])); 

        $prices_sum = array_sum ($request->input('prices',[]));
        $quantities_sum = array_sum ($request->input('quantities',[]));

        if($prices_sum  >250000)
        {
            return redirect()->back()->with('alert', 'Transaction cannot be greater than Ksh.300,000');
        }

        if($prices_sum  < 10)
        {
            return redirect()->back()->with('alert', 'Transaction cannot be less than Ksh.10');
        }


        $user = Auth::user();
        $trns = new Tdetails;
        $trnscode = '';
        
        //For Supamall vendors
        // $vendor = DB::table('ad_supamalluser')
        //      ->select('id')
        //      ->where('name','=', $request->vendor_id)
        //      ->first();
        //dd($vendor);

        $vendor = User::where('phone_number', $user->phone_number)->first();
        $client = User::where('phone_number', $request->client_id)->first();
        //dd($client);

        
        // $email = Auth::user()->email;
        // $data = [
        //     'client_name' => $client->first_name,
        //     'client_phone' => $client->phone_number,
        //     'itemdesc' => $itemdesc,
        //     'quantities' => $quantities,
        //     'prices' => $prices,
        //     'location' => $request->location,
        //     'delivery_time' => $request->deliverytime,
        //     'delivery_fee' => $request->deliveryfee,
        //     'delivery_fee_handler' => $request->delivery_fee_handler,
        // ];
        
        // Mail::to($email)->send(new ThankyouMail($data));

        $trns->vendor_id = $vendor->id;
        $trns->client_id = $client->id;
        $trns->client_phone = $client->phone_number;
        $trns->transactioncode =$trnscode;
        $trns->users_id = $user->id;
        $trns->validated = 0;
        $trns->deposited = $quantities; 
        $trns->delivered = 0;
        $trns->closed=0;
        $trns->deliveryamount= $request->deliveryfee;
        $trns->transamount= $prices; 
        $trns->deliverylocation= $request->location;
        $trns->transdetail= $itemdesc; 
        $trns->suspended=0;
        $trns->expired=0;
        $trns->void=0;
        $trns->delivered=0;
        $trns->suspensionremarks='none';
        //  $vend->acceptedtnc = $request->acceptedtnc;
        $trns->trans_long = $request->long;
        $trns->trans_lat = $request->lat;
        $trns->delivery_time = $request->deliverytime;
        $trns->delivery_fee_handler = 'client';
        $trns->paid = 0;


        $imageName = [];
        $imageArray = $request->product_image;
            if(!empty($imageArray)){
            for ($image=0; $image < count($imageArray); $image++) {
                if ($imageArray[$image] != '') {
                $newImageName = $image . '-' .time() . '-' . $request->vendor_id . '-' . $request->client_id . '.' . $imageArray[$image]->extension();
                $imageArray[$image]->move(public_path('product_images'), $newImageName);
                array_push($imageName, $newImageName);
                }
            }}
        $product_image = implode(" & ", $imageName);
        
        $trns->product_image = $product_image;
        $trns->save();
        
        //Save the product details
        // $products = $request->input('products', []);
        // $quantities = $request->input('quantities', []);
        // $prices = $request->input('prices',[]);
        // $itemdesc = $request->input('itemdesc',[]);
        // $pics = $request->input('pics',[]);
        

        /**
         * Was not sure what the below for loop was doing, so i commented it out.
         * 
         */
        
        // for ($product=0; $product < count($products); $product++) {
        //     if ($products[$product] != '') {
        //         $trns->products()->attach($products[$product], ['itemdetail' => $itemdesc[$product]], ['quantity' => $quantities[$product]], ['price' => $prices[$product]]);
        //         //, ['quantity' => $quantities[$product]], ['price' => $prices[$product]]
              
        //     }
        // }
        return redirect()->route('transactions')->with('success', 'Transaction Added!');
    //}
    }



    public function update(Request $request)
    {
        // $id = $request->id;
        // $trns = Tdetails::find($id);

        // $user = Auth::user();
        // $trnscode = '';

        // $trns->vendor_id=$request->vendor_id;
        // $trns->client_id = $request->client_id;
        // $trns->transactioncode = $trnscode;
        // $trns->users_id = $user->id;
        // $trns->validated = 0;
        // $trns->deposited = $request->quantities;
        // $trns->delivered = 0;
        // $trns->paid = 0;
        // $trns->closed=0;
        // $trns->deliveryamount=0;
        // $trns->transamount=$request->amount;
        // $trns->deliverylocation='delivery details detemined';
        // $trns->transdetail=$request->itemdesc;
        // $trns->suspended=0;
        // $trns->expired=0;
        // $trns->void=0;
        // $trns->delivered=0;
        // $trns->suspensionremarks='none';
        // //  $vend->acceptedtnc = $request->acceptedtnc;
        // $trns->trans_long=0;
        // $trns->trans_lat=0;

        // $trns->save();

        // return redirect()->route('transactions')->with('success', 'Transaction Updated!');

        // dd($request->all());
        $request->validate([
            'client_id' => 'required',
            'itemdesc' => 'required',
            'quantities' => 'required',
            'prices' => 'required',
            'location' => 'required',
            'deliveryfee' => 'required'
        ]);

        // dd($request->all());
        $itemdesc = implode (". ", $request->input('itemdesc',[]));
        $quantities = implode (" ", $request->input('quantities',[]));
        $prices = implode (" ", $request->input('prices',[])); 

        $prices_sum = array_sum ($request->input('prices',[]));
        $quantities_sum = array_sum ($request->input('quantities',[]));

        if($prices_sum  >250000)
        {
            return redirect()->back()->with('alert', 'Transaction cannot be greater than Ksh.300,000');
        }

        if($prices_sum  < 10)
        {
            return redirect()->back()->with('alert', 'Transaction cannot be less than Ksh.10');
        }


        $user = Auth::user();
        // $trns = new Tdetails;
        $id = $request->id;
        $trns = Tdetails::find($id);
        $trnscode = '';

        $vendor = User::where('phone_number', $user->phone_number)->first();
        $client = User::where('phone_number', $request->client_id)->first();

        $trns->vendor_id = $vendor->id;
        $trns->client_id = $client->id;
        $trns->client_phone = $client->phone_number;
        $trns->transactioncode =$trnscode;
        $trns->users_id = $user->id;
        $trns->validated = 0;
        $trns->deposited = $quantities; 
        $trns->delivered = 0;
        $trns->closed=0;
        $trns->deliveryamount= $request->deliveryfee;
        $trns->transamount= $prices; 
        $trns->deliverylocation= $request->location;
        $trns->transdetail= $itemdesc; 
        $trns->suspended=0;
        $trns->expired=0;
        $trns->void=0;
        $trns->delivered=0;
        $trns->suspensionremarks='none';
        //  $vend->acceptedtnc = $request->acceptedtnc;
        $trns->trans_long = $request->long;
        $trns->trans_lat = $request->lat;
        $trns->delivery_time = $request->deliverytime;
        $trns->delivery_fee_handler = 'client';
        $trns->paid = 0;


        $imageName = [];
        $imageArray = $request->product_image;
            if(!empty($imageArray)){
            for ($image=0; $image < count($imageArray); $image++) {
                if ($imageArray[$image] != '') {
                $newImageName = $image . '-' .time() . '-' . $request->vendor_id . '-' . $request->client_id . '.' . $imageArray[$image]->extension();
                $imageArray[$image]->move(public_path('product_images'), $newImageName);
                array_push($imageName, $newImageName);
                }
            }}
        $product_image = implode(" & ", $imageName);
        
        $trns->product_image = $product_image;
        $trns->save();
        
        return redirect()->route('transactions')->with('success', 'Transaction Edited Successfully!');
        
    }
    

    public function generatereceipt()
    {
        $arr = $values;
        return view('receipts.show',compact('arr'));
    }



    public function selectSearch(Request $request)
    {
    	$vendors = [];

        if($request->has('q')){
            $search = $request->q;
            $vendors =DB::table('ad_supamalluser')->select('name')
            		->where('name', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($vendors);
    }

    public function selectSearch2(Request $request)
    {
    	$clients = [];

        if($request->has('q')){
            $search = $request->q;
            $clients = DB::table('users')->select('firstname')
            		->where('firstname', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($clients);
    }

    public function getVendors(Request $request){

        $search = $request->search;
  
        if($search == ''){
           $vendors = DB::table('ad_supamalluser')->select('name')->orderby('name','asc')->limit(5)->get();
        }else{
           $vendors = DB::table('ad_supamalluser')->select('name')->orderby('name','asc')->where('name', 'like', '%' .$search . '%')->limit(5)->get();
        }
  
        $response = array();
        foreach($vendors as $vendor){
           $response[] = array("value"=>$vendor->name,"label"=>$vendor->name);
        }
  
        return response()->json($response);
     }

     public function buyerSearch()
     {
         $buyers = User::get();

         return response()->json($buyers);
     }

     public function send_sms()
    {

        // Your Account SID and Auth Token from twilio.com/console
        $account_sid = 'AC2af25992c5d864b538204bf25188678e';
        $auth_token = '8073b161334e57e4115dc24af0108ec1';
        // In production, these should be environment variables. E.g.:
        // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

        // A Twilio number you own with SMS capabilities
        $twilio_number = "+19362414349";
        $recipient = '+254700682679';

        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipient, 
            ['from' => $twilio_number, 'body' => $message] );
        // $client->messages->create(
        //     // Where to send a text message (your cell phone?)
        //     '+254700682679',
        //     array(
        //         'from' => $twilio_number,
        //         'body' => 'Escrow sent this message for testing'
        //     )
        // );

        return redirect()->route('deliveries')->with('success', 'Message Successfully!');
    }


}
