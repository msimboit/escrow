<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mediations;

class MediationController extends Controller
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
        $arr['mediations'] = Mediations::paginate(10);
        return view('Mediation.index')->with($arr);
    }

    public function create()
    {
        return view('Mediation.create');
    }

    public function show($id)
    {
        $mediation = Mediations::find($id);
        return view('Mediation.show', compact('mediation'));   
    }

    public function edit($id)
    {
        $mediation = Mediations::find($id);
        return view('Mediation.edit', compact('mediation'));   
    }


    public function store(Request $request)
    {
        $mediation = new Mediations;

        $mediation->firstname=$request->clientname;
        $mediation->middlename = $request->clientname;
        $mediation->lastname = $request->clientname;
        $mediation->IdNo = $request->idno;
        $mediation->phoneno = $request->phoneno;
        $mediation->email = $request->email;
        $mediation->country = $request->country;
      //  $client->acceptedtnc = $request->acceptedtnc;
        $mediation->long=0;
        $mediation->lat=0;

        $mediation->save();

        return redirect()->route('Mediation')->with('success', 'Mediation Added!');
    }

    public function update(Request $request, $id)
    {
        //return view('transactions.create');
        $mediation = Mediations::find($id);

        $mediation->firstname=$request->clientname;
        $mediation->middlename = $request->clientname;
        $mediation->lastname = $request->clientname;
        $mediation->IdNo = $request->idno;
        $mediation->phoneno = $request->phoneno;
        $mediation->email = $request->email;
        $mediation->country = $request->country;
      //  $client->acceptedtnc = $request->acceptedtnc;
        $mediation->long=0;
        $mediation->lat=0;

        $mediation->save();

        return redirect()->route('Mediation')->with('success', 'Mediation Updated!');
    
        //return view('transactions.create');
    }

    public function destroy($id)
    {

        $client = Mediations::find($id);
        $client->delete();

        return redirect('/mediations')->with('success', 'Mediation deleted!');
    }
}
