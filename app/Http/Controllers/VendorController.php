<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendors;

class VendorController extends Controller
{
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
        $arr['vendors'] = Vendors::paginate(10);
        return view('vendors.index')->with($arr);
    }

    public function create()
    {
        return view('vendors.create');
    }

    public function show($id)
    {
        $vend = Vendors::find($id);
        return view('vendors.show', compact('vend'));   
    }

    public function edit($id)
    {
        $vend = Vendors::find($id);
        return view('vendors.edit', compact('vend'));   
    }


    public function store(Request $request)
    {
         /*    $vend = Vendors::find($request->phoneno);

            $count = count($vend);

            @if($count =>1)
                {
                <td><a href="#" class="viewPopLink btn btn-default1" role="button" data-id="{{ $user->travel_id }}" data-toggle="modal" data-target="#myModal">Approve/Reject<a></td>
                }
            @else{
 */
            $vend = new Vendors;

            $vend->firstname=$request->firstname;
            $vend->middlename = $request->firstname;
            $vend->lastname = $request->firstname;
            $vend->IdNo = $request->idno;
            $vend->phoneno = $request->phoneno;
            $vend->email = $request->email;
            $vend->country = $request->country;
            $vend->physicaladdress = 'here';
            //  $vend->acceptedtnc = $request->acceptedtnc;
            $vend->vendor_long=0;
            $vend->vendor_lat=0;

            $vend->save();

            return redirect()->route('vendors')->with('success', 'Vendor Added!');
        
      /*   }
        @endif */
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

        return redirect()->route('vendors')->with('success', 'Vendor Updated!');
    
        //return view('transactions.create');
    }

    public function destroy($id)
    {
        $vend = Vendors::find($id);
        $vend->delete();

        return redirect('/vendors')->with('success', 'Vendor deleted!');
    }


}
