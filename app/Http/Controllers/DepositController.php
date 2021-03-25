<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deposits;

class DepositController extends Controller
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
        $arr['deposits'] = Deposits::paginate(10);
        return view('deposits.index')->with($arr);
    }

    public function create()
    {
        return view('deposits.create');
    }

    public function show()
    {
        return view('deposits.show');
    }

    public function edit()
    {
        return view('deposits.edit');
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
