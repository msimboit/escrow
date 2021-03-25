<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deliveries;


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
        $arr['deliveries'] = Deliveries::paginate(10);
        return view('delivery.index')->with($arr);
    }

    public function create()
    {
        return view('delivery.create');
    }

    public function show($id)
    {
        $deliveries = Deliveries::find($id);
        return view('delivery.show', compact('deliveries'));   
    }

    public function edit($id)
    {
        $deliveries = Deliveries::find($id);
        return view('delivery.edit', compact('deliveries'));   
    }


    public function store(Request $request)
    {
        $client = new Deliveries;

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

        return redirect()->route('deliveries')->with('success', 'Delivery Added!');
    }

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
