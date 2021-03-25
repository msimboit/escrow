<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tdetails;


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
        $arr['transactions'] = Tdetails::where('void','=',0) 
                                        ->get();
        return view('home')->with($arr);
        //return view('home');
    }
}
