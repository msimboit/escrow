<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tdetails;
use App\Vendors;
use App\Clients;
use App\Product;
use Auth;



class ProductsController extends Controller
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
        $arr['prds'] = Product::paginate(10);
        return view('products.index')->with($arr);
    }

    public function create()
    {
            $items = Vendors::pluck('firstname', 'id');
            $clients = Clients::pluck('firstname', 'id');
            $products = Product::pluck('name','id');

            $selectedID = 2;

            return view('products.create');
    
    }

    public function show()
    {
        return view('products.show');
    }

    public function edit()
    {
        return view('products.edit');
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        $trns = new Tdetails;

        $trns->vendor_id=$request->vendorid;
        $trns->client_id = $request->firstname;
        $trns->transactioncode = $request->firstname;
        $trns->users_id = $user->id;
        $trns->validated = 'false';
        $trns->deposited = 'false';
        $trns->delivered = 'false';
        $trns->closed='false';
        $trns->deliveryamount=0;
        $trns->transamount=0;
        $trns->deliverylocation='delivery details detemined';
        $trns->transdetail='products';
        $trns->suspended='false';
        $trns->expired='false';
        $trns->void='false';
        $trns->delivered='false';
        $trns->suspensionremarks='none';
        //  $vend->acceptedtnc = $request->acceptedtnc;
        $trns->trans_long=0;
        $trns->trans_lat=0;

        $trns->save();

        return redirect()->route('products')->with('success', 'Vendor Added!');
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

        return redirect()->route('products')->with('success', 'Vendor Updated!');
    
        //return view('transactions.create');
    }


}
