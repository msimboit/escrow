<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tdetails;
use App\Vendors;
use App\Clients;
use App\Product;
use App\mpesa_token;
use Auth;
use Log;



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
        $arr['trs'] = Tdetails::paginate(100);
        $vendors = Vendors::all();
        $clients = Clients::all();

        return view('transactions.index')->with($arr);
    }

    public function create()
    {
            $items = Vendors::pluck('firstname', 'id');
            $clients = Clients::pluck('firstname', 'id');

            Log::info($items);
            $prds = Product::all(); /*('name','id');*/
            Log::info('
            
            
            '
            );
            Log::info($prds);
            $selectedID = 2;

            return view('transactions.create', compact('items','clients','prds'));
    
    }

    public function show($id)
    {
        $arr = Tdetails::where('id', $id)->first();
        Log::info($arr);
        $vdetails = Vendors::where('id', $arr->vendor_id)->first();
        $cdetails = Clients::where('id', $arr->client_id)->first();
        return view('transactions.show', compact('arr', 'vdetails', 'cdetails'))->with($id);
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
        //if($request->submit == 'saveorder'){

       

        $user = Auth::user();
        $trns = new Tdetails;
        $trnscode = '';


        $trns->vendor_id=$request->vendor_id;
        $trns->client_id = $request->client_id;
        $trns->transactioncode =$trnscode;
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
        Log::info('
        
        
        ');
        Log::info('transaction: ' . $trns);

        //Save the product details
        $products = $request->input('products', []);
        $quantities = $request->input('quantities', []);
        $prices = $request->input('prices',[]);
        $itemdesc = $request->input('itemdesc',[]);
        $pics = $request->input('pics',[]);
        
        Log::info('
        
        
        ');
        Log::info($products);
        Log::info('
        
        ');
        Log::info('quantities: ');
        Log::info($quantities);
   
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
    
    public function receipt(Request $request)
    {
        $values = $request->all();
        return $values;
    }

}
