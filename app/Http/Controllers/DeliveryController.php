<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deliveries;
use App\Tdetails;
use App\Clients;
use DB;


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
        $arr['deliveries'] = Tdetails::paginate(100);
        $vendor_id = (($arr['deliveries'][0])->vendor_id);
        //dd($vendor_id);

        $vendor = DB::table('ad_supamalluser')
             ->where('id','=', $vendor_id)
             ->first();

        $client_id = (($arr['deliveries'][0])->vendor_id);
        $client = Clients::where('id', $client_id)->first();
        //dd($arr);
        return view('delivery.index', compact('vendor','client'))->with($arr);
    }

    public function create()
    {
        return view('delivery.create');
    }

    public function show($id)
    {
        $arr = Tdetails::where('id', $id)->first();
        $vdetails = DB::table('ad_supamalluser')->where('id', '=', $arr->vendor_id)->first();
        $cdetails = Clients::where('id', $arr->client_id)->first();
        $itemdesc = explode(". ", $arr->transdetail);
        $quantities = explode(" ", $arr->deposited);
        $prices = explode(" ", $arr->transamount);
        $product_image = explode(" & ", $arr->product_image);
        return view('delivery.show', compact('arr', 'vdetails', 'cdetails', 'itemdesc', 'product_image', 'quantities', 'prices'))->with($id);
        //return $vdetails;
    }

    public function edit($id)
    {
        $deliveries = Deliveries::find($id);
        return view('delivery.edit', compact('deliveries'));   
    }


    /** 
     * Cant add a delivery since it picks from the transactions.
     * */ 
    
    // public function store(Request $request)
    // {
    //     $client = new Deliveries;

    //     $client->firstname=$request->clientname;
    //     $client->middlename = $request->clientname;
    //     $client->lastname = $request->clientname;
    //     $client->IdNo = $request->idno;
    //     $client->phoneno = $request->phoneno;
    //     $client->email = $request->email;
    //     $client->country = $request->country;
    //   //  $client->acceptedtnc = $request->acceptedtnc;
    //     $client->long=0;
    //     $client->lat=0;

    //     $client->save();

    //     return redirect()->route('deliveries')->with('success', 'Delivery Added!');
    // }

    
    public function update(Request $request, $id)
    {
        //return view('transactions.create');
        $client = Deliveries::find($id);

        $client->firstname=$request->clientname;
        $client->middlename = $request->clientname;
        $client->lastname = $request->clientname;
        $client->IdNo = $request->idno;
        $client->phoneno = $request->phoneno;
        $client->email = $request->email;
        $client->country = $request->country;
      //  $client->acceptedtnc = $request->acceptedtnc;
        $client->long=0;
        $client->lat=0;

        $client->save();

        return redirect()->route('deliveries')->with('success', 'Delivery Updated!');
    
        //return view('transactions.create');
    }

    public function destroy($id)
    {

        $client = Deliveries::find($id);
        $client->delete();

        return redirect('/deliveries')->with('success', 'Deliery deleted!');
    }
}
