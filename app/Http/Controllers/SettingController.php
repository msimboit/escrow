<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;


class SettingController extends Controller
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
        $arr['settings'] = Settings::paginate(10);
        return view('settings.index')->with($arr);
    }

    public function create()
    {
        return view('settings.create');
    }

    public function show()
    {
        return view('settings.show');
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
