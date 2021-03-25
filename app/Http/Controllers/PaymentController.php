<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payments;


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
        $arr['payments'] = Payments::paginate(10);
        return view('payments.index')->with($arr);
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
