<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Tdetails;
use App\User;
use App\Deliveries;
use Carbon\Carbon;
use Auth;
use DB;
use Log;


class HomeController extends Controller
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
        if(Auth::user()->role == 'admin')
        {
            return redirect()->route('transactions');
        }
        $arr['transactions'] = Tdetails::where('void','=',0) 
                                        ->get();
        $users = User::all();
        $vendors = User::where('role','vendor')->get();
        $deliveries = Tdetails::where('delivered','=',1)->get();

        $id = Auth::user()->id;
        $buyer_transactions = Tdetails::where('client_id',$id)->get();
        $vendor_transactions = Tdetails::where('vendor_id',$id)->get();
        $transactions_count = (collect($vendor_transactions)->count())+(collect($buyer_transactions)->count());

        $total_spent = [];
        foreach($buyer_transactions as $bt)
        {
            $buying_amount = collect(explode(' ',$bt->transamount))->sum();
            array_push($total_spent, $buying_amount);
        }

        $total_spent = array_sum($total_spent);

        $buyer_successful_deliveries = Tdetails::where('client_id',$id)->where('closed', 1)->get();
        $vendor_successful_deliveries = Tdetails::where('vendor_id',$id)->where('closed', 1)->get();
        $successful_deliveries = (collect($vendor_successful_deliveries)->count())+(collect($buyer_successful_deliveries)->count());

        $highest_vendor = Tdetails::where('client_id',$id)
            ->select('vendor_id')
            ->selectRaw('COUNT(*) AS count')
            ->groupBy('vendor_id')
            ->orderByDesc('count')
            ->limit(1)
            ->first();
        $highest_vendor = User::where('id', $highest_vendor->vendor_id)->first();

        if(Auth::user()->role == 'vendor')
        {
            $highest_buyer = Tdetails::where('vendor_id',$id)
                            ->select('client_id')
                            ->selectRaw('COUNT(*) AS count')
                            ->groupBy('client_id')
                            ->orderByDesc('count')
                            ->limit(1)
                            ->first();

            $highest_buyer = User::where('id', $highest_buyer->client_id)->first();
        }
        else {
            $id = Auth::user()->id;
            $highest_buyer = User::where('id', $id)->first();
        }
        

        return view('home', compact('users',
                                    'vendors',
                                    'deliveries', 
                                    'transactions_count', 
                                    'total_spent',
                                    'successful_deliveries',
                                    'highest_buyer',
                                    'highest_vendor')
                    )->with($arr);
    }
}
