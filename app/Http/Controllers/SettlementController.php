<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settlements;


class SettlementController extends Controller
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
        $arr['settlements'] = Settlements::paginate(10);
        return view('settlements.index')->with($arr);
    }

    public function create()
    {
        return view('settlements.create');
    }

    public function show()
    {
        return view('settlements.show');
    }

    public function edit()
    {
        return view('settlements.edit');
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
