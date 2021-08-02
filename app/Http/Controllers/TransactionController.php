<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tdetails;
use App\Vendors;
use App\Clients;
use App\Product;
use App\mpesa_token;
use Auth;
use Log;
use DB;



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
        $transactions = Tdetails::orderBy('created_at', 'desc')->paginate(100);
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
            $clients = User::where('role', 'client')->get();
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
        
        //$vdetails = Vendors::where('id', $arr->vendor_id)->first();
    
        $vdetails = User::where('id', $arr->vendor_id)->first();
        /* Added the square brackets because vdetails returns a collection */
        //$vdetails = $vdetails[0];
        $cdetails = User::where('phone_number', $arr->client_phone)->first();

        $itemdesc = explode(". ", $arr->transdetail);
        $quantities = explode(" ", $arr->deposited);
        $prices = explode(" ", $arr->transamount);
        $product_image = explode(" & ", $arr->product_image);
        // dd($product_image);
        return view('transactions.show', compact('arr', 'vdetails', 'cdetails', 'itemdesc', 'product_image', 'quantities', 'prices'))->with($id);
    }

    public function edit($id)
    {
        $items = Vendors::pluck('firstname', 'id');
        $clients = Clients::pluck('firstname', 'id');
        $prds = Product::all();
        $selectedID = 2;

        $trans = Tdetails::where('id', $id)->first();
        return view('transactions.edit', compact('trans','items','clients','prds'))->with($id);
    }


    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'itemdesc' => 'required',
            'quantities' => 'required',
            'prices' => 'required',
            'location' => 'required',
            'deliveryfee' => 'required'
        ]);

        //dd($request->all());
        $itemdesc = implode (". ", $request->input('itemdesc',[]));
        $quantities = implode (" ", $request->input('quantities',[]));
        $prices = implode (" ", $request->input('prices',[])); 

        $prices_sum = array_sum ($request->input('prices',[]));
        $quantities_sum = array_sum ($request->input('quantities',[]));


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

        //dd($user);

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
        $trns->delivery_fee_handler = $request->delivery_fee_handler;


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
    //    dd($trns);
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
        $id = $request->id;
        Log::info($id);
        $trns = Tdetails::find($id);

        $user = Auth::user();
        $trnscode = '';

        $trns->vendor_id=$request->vendor_id;
        $trns->client_id = $request->client_id;
        $trns->transactioncode = $trnscode;
        $trns->users_id = $user->id;
        $trns->validated = 0;
        $trns->deposited = $request->quantities;
        $trns->delivered = 0;
        $trns->closed=0;
        $trns->deliveryamount=0;
        $trns->transamount=$request->amount;
        $trns->deliverylocation='delivery details detemined';
        $trns->transdetail=$request->itemdesc;
        $trns->suspended=0;
        $trns->expired=0;
        $trns->void=0;
        $trns->delivered=0;
        $trns->suspensionremarks='none';
        //  $vend->acceptedtnc = $request->acceptedtnc;
        $trns->trans_long=0;
        $trns->trans_lat=0;

        $trns->save();

        return redirect()->route('transactions')->with('success', 'Transaction Updated!');
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


}
