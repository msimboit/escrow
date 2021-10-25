<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Disputes;


class DisputeController extends Controller
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
        $arr['disputes'] = Disputes::paginate(10);
        return view('disputes.index')->with($arr);
    }

    public function create()
    {
        return view('disputes.create');
    }

    public function show()
    {
        return view('disputes.show');
    }

    public function edit()
    {
        return view('disputes.edit');
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
