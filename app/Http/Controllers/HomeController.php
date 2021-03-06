<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
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

        if(Auth::user()->role == 'customer_care')
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

        if(Auth::user()->role == 'buyer')
        {
            $highest_vendor = Tdetails::where('client_id',$id)
                        ->select('vendor_id')
                        ->selectRaw('COUNT(*) AS count')
                        ->groupBy('vendor_id')
                        ->orderByDesc('count')
                        ->limit(1)
                        ->first();
        }
        else{
            $highest_vendor = null;
        }
        

        // if($highest_vendor == null || $highest_vendor == '')
        // {
        //     $transactions_count = 0;
        //     $total_spent = 0;
        //     $successful_deliveries = 0;
        //     $highest_buyer = null;
        //     $highest_vendor = null;
        //     return view('home', compact('users',
        //                             'vendors',
        //                             'deliveries', 
        //                             'transactions_count', 
        //                             'total_spent',
        //                             'successful_deliveries',
        //                             'highest_buyer',
        //                             'highest_vendor')
        //             )->with($arr);
        // }
        // $highest_vendor = User::where('id', $highest_vendor->vendor_id)->first();

        if(Auth::user()->role == 'vendor' && $vendor_transactions == null)
        {
            $transactions_count = 0;
            $total_spent  = 0;
            $successful_deliveries = 0;
            $highest_buyer = null;
            $highest_vendor = null;
            $sales_amount = 0;
            return view('home', compact('users',
                                    'vendors',
                                    'deliveries', 
                                    'transactions_count', 
                                    'total_spent',
                                    'successful_deliveries',
                                    'highest_buyer',
                                    'highest_vendor',
                                    'sales_amount')
                    )->with($arr);

        }

        if(Auth::user()->role == 'vendor')
        {
            $highest_buyer = Tdetails::where('vendor_id',$id)
                            ->select('client_id')
                            ->selectRaw('COUNT(*) AS count')
                            ->groupBy('client_id')
                            ->orderByDesc('count')
                            ->limit(1)
                            ->first();

            if($highest_buyer != null){
                $highest_buyer = User::where('id', $highest_buyer->client_id)->first();
            }
            
            $sales_amount = [];
            foreach($vendor_successful_deliveries as $vt)
            {
                $selling_amount = collect(explode(' ',$vt->transamount))->sum();
                array_push($sales_amount, $selling_amount);
            }
    
            $sales_amount = array_sum($sales_amount);

            return view('home', compact('users',
                                    'vendors',
                                    'deliveries', 
                                    'transactions_count', 
                                    'total_spent',
                                    'successful_deliveries',
                                    'highest_buyer',
                                    'highest_vendor',
                                    'sales_amount')
                    )->with($arr);
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


    /**
     * Edit the users information
     */
    public function editUser($id)
    {
        $user = User::where('id', $id)->first();
        return view('test', compact('user'));
    }

    /**
     * Update the users information
     */
    public function updateUser(Request $request)
    {
        // dd($request->all());
        User::where('phone_number', $request->phone_number)
            ->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'role' => $request->role,
            'business_name' => $request->business_name,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('vendors')->with('status', 'User profile updated successfully!');
    }

    /**
     * Soft Delete the users information
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('', 'User profile deleted successfully!');
    }

    /**
     * Change User Password from Client side
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        if(!Hash::check($request->old_password, $user->password))
        {
            return redirect('profile')->with('alert', 'Old Password did not match!');
        }

        $password = $request->new_password;
        $user->password = Hash::make($password);
        $user->save();

        return redirect('profile')->with('success', 'Password Changed Successfully!');
    }

}
