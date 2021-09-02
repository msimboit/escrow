<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Tdetails;
use App\Vendors;
use App\Clients;
use App\Product;
use App\mpesa_token;
use Auth;
use Log;
use DB;

class ProfileController extends Controller
{
    public function show()
    {
        $transactions = "None" ? Tdetails::where('vendor_id', Auth::user()->id)->get() : Tdetails::where('client_id', Auth::user()->id)->get();
        return view('profile', compact('transactions'));
    }
}
