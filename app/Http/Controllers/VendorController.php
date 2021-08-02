<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Vendors;
use App\Ad_supamalluser;


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
        /*Supamall Vendors */
        // $arr['vendors'] = DB::table('ad_supamalluser')->orderBy('phone', 'desc')
        // ->orderBy('id', 'asc')
        // ->paginate(20);
        // return view('vendors.index')->with($arr);

        $vendors = User::where('role', 'vendor')->paginate(20);
        // dd($arr);
        return view('vendors.index', compact('vendors'));
        
        
    }

    public function create()
    {
        return view('vendors.create');
    }

    public function show($id)
    {
        /*
        $vend = Vendors::find($id);
        return view('vendors.show', compact('vend'));  
        */
        
        $vend = DB::table('ad_supamalluser')->where('id', $id)->first();
        return view('vendors.show', compact('vend'));
       // return view('vendors.show')->with($vend);
    }

    public function edit($id)
    {
        /*
        $vend = Vendors::find($id);
        return view('vendors.edit', compact('vend'));   
        */

        $vend = DB::table('ad_supamalluser')->where('id', $id)->first();
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
            $vend->middlename = $request->middlename;
            $vend->lastname = $request->lastname;
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
        $id = $request->id;
        //$vend = Vendors::find($id);
        $vend = DB::table('ad_supamalluser')->where('id', $id)->first();

        $vend->name=$request->name;
        $vend->username = $request->username;
        $vend->description = $request->description;
        $vend->confirm = $request->idno;
        $vend->phone = $request->phone;
        $vend->email = $request->email;
        $vend->country = $request->country;
        $vend->user_type = 'seller';

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
    
    public function search(Request $request)
    {
        //dd($request->all());
        $search = User::query()
            ->where('phone_number', 'like', "%{$request->q}%")
            ->where('role', 'vendor')
            ->orderBy('created_at', 'desc')
            ->first();
        // dd($search->first_name);
        return view('vendors.search', ['search' => $search]);
    }

}
