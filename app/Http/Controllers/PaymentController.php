<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Payments;
use DB;


class PaymentController extends Controller
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
        if(Gate::denies('admin', auth()->user())){
            abort(403);
        }
        $arr['payments'] = DB::table('settlements')->orderBy('id', 'desc')->paginate(10);
        return view('Payments.index')->with($arr);
    }

    public function create()
    {
        return view('payments.create');
    }

    public function show()
    {
        return view('payments.show');
    }

    public function edit()
    {
        return view('payments.edit');
    }


    public function store()
    {
       // return view('transactions.create');
    }

    public function update()
    {
        //return view('transactions.create');
    }
}
