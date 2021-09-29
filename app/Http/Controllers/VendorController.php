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

        $vendors = User::where('role', 'vendor')->paginate(20);
        return view('vendors.index', compact('vendors'));
        
        
    }

    /**
     * Validation of the vendor
     */
    public function validateVendor($id)
    {

        $vend = User::where('id', $id)->first();

        $update_users_table = DB::table('users')
                                    ->where('id', $id)
                                    ->update([
                                    'validated' => '1'
                                ]);

        $vendors = User::where('role', 'vendor')->paginate(20);

        return view('vendors.index', compact('vendors'))->with('success', 'Vendor has been successfully validated!'); 
    }

    /**
     * Devalidation of the vendor
     */
    public function devalidateVendor($id)
    {

        $vend = User::where('id', $id)->first();

        $update_users_table = DB::table('users')
                                    ->where('id', $id)
                                    ->update([
                                    'validated' => '0'
                                ]);

        $vendors = User::where('role', 'vendor')->paginate(20);

        return view('vendors.index', compact('vendors'))->with('success', 'Vendor has been successfully Devalidated!'); 
    }


    public function create()
    {
        return view('vendors.create');
    }

    public function show($id)
    {

        $vend = DB::table('ad_supamalluser')->where('id', $id)->first();
        return view('vendors.show', compact('vend'));

    }

    public function edit($id)
    {
        $vend = DB::table('ad_supamalluser')->where('id', $id)->first();
        return view('vendors.edit', compact('vend')); 
    }


    public function store(Request $request)
    {
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
    }

    public function update(Request $request)
    {
        $id = $request->id;
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
    }

    public function destroy($id)
    {
        $vend = Vendors::find($id);
        $vend->delete();

        return redirect('/vendors')->with('success', 'Vendor deleted!');
    }
    
    public function search(Request $request)
    {
        $search = User::query()
            ->where('phone_number', 'like', "%{$request->q}%")
            ->where('role', 'vendor')
            ->orderBy('created_at', 'desc')
            ->first();
        return view('vendors.search', ['search' => $search]);
    }

}
