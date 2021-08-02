<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clients;
use App\User;

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
        $arr['clients'] = User::where('role', 'client')->paginate(10);
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

    public function location($id){
        $client = Clients::find($id);
        return view('clients.location', compact('client'));
    }

    public function updatelocation($id){
        $client = Clients::find($id);
        $client->firstname=$request->firstname;
        $client->middlename = $request->middlename;
        $client->lastname = $request->lastname;
        $client->IdNo = $request->idno;
        $client->phoneno = $request->phoneno;
        $client->email = $request->email;
        $client->country = $request->country;
      //  $client->acceptedtnc = $request->acceptedtnc;
        $client->client_long=0;
        $client->client_lat=0;

        $client->save();

        return redirect()->route('clients')->with('success', 'Client Added!');
    }


    public function store(Request $request)
    {
        $client = new Clients;

        $client->firstname=$request->firstname;
        $client->middlename = $request->middlename;
        $client->lastname = $request->lastname;
        $client->IdNo = $request->idno;
        $client->phoneno = $request->phoneno;
        $client->email = $request->email;
        $client->country = $request->country;
        $client->physicaladdress = 'here';
      //  $client->acceptedtnc = $request->acceptedtnc;
        $client->client_long= $request->lat;
        $client->client_lat= $request->long;

        $client->save();

        return redirect()->route('clients')->with('success', 'Client Added!');
    }

    public function update(Request $request, $id)
    {
        //return view('transactions.create');
        $client = Clients::find($id);

        $client->firstname=$request->firstname;
        $client->middlename = $request->middlename;
        $client->lastname = $request->lastname;
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
