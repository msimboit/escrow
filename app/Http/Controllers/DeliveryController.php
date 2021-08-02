<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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
        $deliveries = Tdetails::where('delivered', '0')->paginate(100);
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
        return view('Delivery.show', compact('arr', 'vdetails', 'cdetails', 'itemdesc', 'product_image', 'quantities', 'prices'))->with($id);
        //return $vdetails;
    }

    public function edit($id)
    {
        $deliveries = Deliveries::find($id);
        return view('Delivery.edit', compact('deliveries'));   
    }

    public function acceptDelivery(Request $request) {
        $update_table = DB::table('tdetails')
                         ->where('id', $request->input('orderId'))
                         ->update([
                        'delivered' => '1'                                                                 
                ]);

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
        $search = Tdetails::query()
            ->where('client_phone', 'like', "%{$request->q}%")
            ->orderBy('created_at', 'desc')
            ->get();
        // dd($search[0]->client_phone);
        return view('Delivery.search', ['search' => $search]);
    }
}
