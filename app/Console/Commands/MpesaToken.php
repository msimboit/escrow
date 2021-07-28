<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\mpesa_token;
use App\Http\Controllers\MpesaController;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use DB;
use Log;
use DateTime;

class MpesaToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mpesa_token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $consumer_key = 'oeazFs2H1ywGrmGAw0FqUzEOrHyPVzVw';
        $consumer_secret = 'DxpO6qlcsKMABZK8';
        $credentials        = base64_encode($consumer_key.":".$consumer_secret);

        $url    = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        // $url    = "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        $curl   = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials));
        curl_setopt($curl, CURLOPT_HEADER,false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response  = curl_exec($curl);
        //$curl_info = curl_getinfo($curl);
        Log::info('access token '.$curl_response);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $access_token   = json_decode($curl_response);
        $store_token = $access_token->access_token;

        if($store_token!=='') {
            $check = DB::table('mpesa_tokens')
                ->where('id', '=', 1)
                ->count();
            if ($check >= 1) {
                mpesa_token::where('id',1)
                    ->update(['access_token'=>$store_token]);
            } else {

                $mpesa_tkn = new mpesa_token([
                    'access_token' => $store_token,
                ]);
                $mpesa_tkn->save();
            }


        }

        echo('Generated New Mpesa Token');

    }



}
