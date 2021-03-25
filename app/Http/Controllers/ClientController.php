<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clients;

class ClientController extends Controller
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
        $arr['clients'] = Clients::paginate(10);
        return view('clients.index')->with($arr);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show($id)
    {
        $client = Clients::find($id);
        return view('clients.show', compact('client'));   
    }

    public function edit($id)
    {
        $client = Clients::find($id);
        return view('clients.edit', compact('client'));   
    }


    public function store(Request $request)
    {
        $client = new Clients;

        $client->firstname=$request->clientname;
        $client->middlename = $request->clientname;
        $client->lastname = $request->clientname;
        $client->IdNo = $request->idno;
        $client->phoneno = $request->phoneno;
        $client->email = $request->email;
        $client->country = $request->country;
        $client->physicaladdress = 'here';
      //  $client->acceptedtnc = $request->acceptedtnc;
        $client->client_long=0;
        $client->client_lat=0;

        $client->save();

        return redirect()->route('clients')->with('success', 'Client Added!');
    }

    public function update(Request $request, $id)
    {
        //return view('transactions.create');
        $client = Clients::find($id);

        $client->firstname=$request->clientname;
        $client->middlename = $request->clientname;
        $client->lastname = $request->clientname;
        $client->IdNo = $request->idno;
        $client->phoneno = $request->phoneno;
        $client->email = $request->email;
        $client->country = $request->country;
      //  $client->acceptedtnc = $request->acceptedtnc;
        $client->client_long=0;
        $client->client_lat=0;

        $client->save();

        return redirect()->route('clients')->with('success', 'Vendor Updated!');
    
        //return view('transactions.create');
    }

    public function destroy($id)
    {

        $client = Clients::find($id);
        $client->delete();

        return redirect('/clients')->with('success', 'Client deleted!');
    }
}
