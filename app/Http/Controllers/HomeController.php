<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Tdetails;
use App\User;
use App\Deliveries;


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

        $users = User::all();
        $deliveries = Tdetails::where('delivered','=',1)->get();
        
        return view('home', compact('users', 'deliveries'))->with($arr);
    }

    /**
     * Testing Things
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function tests()
    {
        $arr = array('numbers' => '0797740687', 'message' => 'Message From Ujumbe', 'sender' =>'DEPTHSMS');
        $message_bag = array('message_bag' => $arr);
        $data = array('data'=> [$message_bag]);

        $url = 'http://ujumbesms.co.ke/api/messaging';
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                    CURLOPT_URL => $url,
                    CURLOPT_HTTPHEADER => array('x-authorization: MDE4MzA3N2E1YjQ3YTBmZjZlOWRhMzk5ZDllM2Rk', 'email:abraham.nyabera@msimboit.net'),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($data)
                )
        );
        $curl_response = curl_exec($curl);
        curl_close($curl);
        $res = $curl_response;
        dd($res);
        return $res;

        // $data = json_encode($data);
        // $response = Http::withHeaders([
        //     'X-Authorization' => 'MDE4MzA3N2E1YjQ3YTBmZjZlOWRhMzk5ZDllM2Rk',
        //     'Email' => 'abraham.nyabera@msimboit.net'
        // ])->post('http://ujumbesms.co.ke/api/messaging', [$data]);

        // dd($response);
    }
}
