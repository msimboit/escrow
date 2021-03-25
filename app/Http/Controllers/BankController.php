<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banks;


class BankController extends Controller
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
        $arr['bnks'] = Banks::paginate(10);
        return view('abanks.index')->with($arr);
    }

    public function create()
    {
        return view('abanks.create');
    }

    public function show($id)
    {
        $banking = Banks::find($id);
        return view('abanks.show', compact('banking'));   
    }

    public function edit($id)
    {
    
        $banking = Banks::find($id);
        return view('abanks.edit', compact('banking'));   
    }


    public function store(Request $request)
    {
        $banking = new Banks;

        $banking->bank=$request->bankname;
        $banking->bankname = $request->bankname;
        $banking->bankaddress = $request->bankaddress;
        $banking->bankbranch = $request->bankbranch;
        $banking->contact = $request->contact;
        $banking->accountno = $request->accountno;
        $banking->accountname = $request->accountname;
        $banking->paybill = $request->paybill;
        $banking->email = $request->email;
        $banking->swiftcode = $request->swiftcode;
        $banking->long=0;
        $banking->lat=0;

        $banking->save();

        return redirect()->route('abanks')->with('success', 'New Acquiring Bank Saved!');
    }

    public function update(Request $request, $id)
    {
        //return view('transactions.create');
        $banking = Banks::find($id);

        $banking->bank=$request->bankname;
        $banking->bankname = $request->bankname;
        $banking->bankaddress = $request->bankaddress;
        $banking->bankbranch = $request->bankbranch;
        $banking->contact = $request->contact;
        $banking->accountno = $request->accountno;
        $banking->accountname = $request->accountname;
        $banking->paybill = $request->paybill;
        $banking->email = $request->email;
        $banking->swiftcode = $request->swiftcode;
        $banking->long=0;
        $banking->lat=0;

        $banking->save();

        return redirect()->route('abanks')->with('success', 'Acquiring Bank Updated!');

    }

    public function destroy($id)
    {
        $banking = Banks::find($id);
        $banking->delete();

        return redirect('/abanks')->with('success', 'Bank deleted!');
    }


}
