<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tdetails;
use App\Vendors;
use App\Clients;
use App\Product;
use Auth;



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
        return view('transactions.index')->with($arr);
    }

    public function create()
    {
            $items = Vendors::pluck('firstname', 'id');
            $clients = Clients::pluck('firstname', 'id');
            $prds = Product::all(); /*('name','id');*/

            $selectedID = 2;

            return view('transactions.create', compact('items','clients','prds'));
    
    }

    public function show(Tdetails $tdetails)
    {
        $arr = Tdetails::find($tdetails->id);
        return view('transactions.show')->with($arr);
    }

    public function edit()
    {
        return view('transactions.edit');
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
        $trns->deposited = 0;
        $trns->delivered = 0;
        $trns->closed=0;
        $trns->deliveryamount=0;
        $trns->transamount=0;
        $trns->deliverylocation='delivery details detemined';
        $trns->transdetail='products';
        $trns->suspended=0;
        $trns->expired=0;
        $trns->void=0;
        $trns->delivered=0;
        $trns->suspensionremarks='none';
        //  $vend->acceptedtnc = $request->acceptedtnc;
        $trns->trans_long=0;
        $trns->trans_lat=0;

        $trns->save();

        //Save the product details
        $products = $request->input('products', []);
        $quantities = $request->input('quantities', []);
        $prices = $request->input('prices',[]);
        $itemdesc = $request->input('itemdesc',[]);
        $pics = $request->input('pics',[]);

   
        for ($product=0; $product < count($products); $product++) {
            if ($products[$product] != '') {
                $trns->products()->attach($products[$product], ['itemdetail' => $itemdesc[$product]], ['quantity' => $quantities[$product]], ['price' => $prices[$product]]);
                //, ['quantity' => $quantities[$product]], ['price' => $prices[$product]]
              
            }
        }

        return redirect()->route('transactions')->with('success', 'Transaction Added!');
    //}
    }

    public function update(Request $request)
    {
        //return view('transactions.create');
        $id = $request->id;
        $vend = Vendors::find($id);

        $vend->firstname=$request->firstname;
        $vend->middlename = $request->firstname;
        $vend->lastname = $request->firstname;
        $vend->IdNo = $request->idno;
        $vend->phoneno = $request->phoneno;
        $vend->email = $request->email;
        $vend->country = $request->country;
       // $vend->acceptedtnc = $request->acceptedtnc;
        $vend->long=0;
        $vend->lat=0;

        $vend->save();

        return redirect()->route('transactions')->with('success', 'Transactn Updated!');
    
        //return view('transactions.create');
    }


}
