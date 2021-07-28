<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Log;
use DB;

use App\Clients;
use App\User;
use App\Tdetails;
use App\Vendors;
use App\mpesa_token;

class MpesaController extends Controller
{
    /**
     * Lipa na M-PESA password
     * */
    public function lipaNaMpesaPassword(){

        $lipa_time              = Carbon::rawParse('now')->format('YmdHms');
        $passkey                = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $BusinessShortCode      = 174379;
        $timestamp              = $lipa_time;
        $lipa_na_mpesa_password = base64_encode($BusinessShortCode.$passkey.$timestamp);

        return $lipa_na_mpesa_password;
    }
    /**
     * Lipa na M-PESA STK Push 
     * 
     * @return [curl] response
     *
     **/
    // public function customerMpesaSTKPush(){

    //     $phone_number = 254713374606;
    //     $amount = 1;

    //     $url    = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        

    //     $curl   = curl_init();

    //     curl_setopt( $curl, CURLOPT_URL, $url );
    //     curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Content-Type:application/json','Authorization:Bearer '.$this->generateAccessToken()) );
        
    //     Log:info($this->generateAccessToken());

    //     $curl_post_data = [

    //         //Fill in the request parameters with valid values
            
    //         'BusinessShortCode' => 174379,
    //         'Password'          => $this->lipaNaMpesaPassword(),
    //         'Timestamp'         => Carbon::rawParse('now')->format('YmdHms'),
    //         'TransactionType'   => 'CustomerPayBillOnline',
    //         'Amount'            => 1,
    //         'PartyA'            => $phone_number, // replace this with your phone number
    //         'PartyB'            => 174379,
    //         'PhoneNumber'       => $phone_number, // replace this with your phone number
    //         'CallBackURL'       => 'https://c52e5ec177a8.ngrok.io/api/mpesa_response',
    //         'AccountReference'  => $phone_number,
    //         'TransactionDesc'   => "Testing stk push on sandbox"
    //     ];
        
    //     $data_string = json_encode($curl_post_data);

    //     Log::info($data_string . 'Data String');

    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl, CURLOPT_POST, true);
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        
    //     Log::info($curl. 'Curl');
    //     $curl_response = curl_exec($curl);
        
    //     Log::info($curl_response . 'Response');
    //     return $curl_response;
    // }




    public function customerMpesaSTKPush($phone_number, $amount){
        // $phone_number = 254700682679;
        // $amount = 1;
        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $curl = curl_init();
        
        curl_setopt( $curl, CURLOPT_URL, $url );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Content-Type:application/json','Authorization:Bearer '.$this->generateAccessToken()) );
        
        $curl_post_data = [
        
        //Fill in the request parameters with valid values
        'BusinessShortCode' => 174379,
        'Password' => $this->lipaNaMpesaPassword(),
        'Timestamp' => Carbon::rawParse('now')->format('YmdHms'),
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => 1,
        'PartyA' => $phone_number, // replace this with your phone number
        'PartyB' => 174379,
        'PhoneNumber' => $phone_number, // replace this with your phone number
        'CallBackURL' => 'http://phplaravel-607367-1966954.cloudwaysapps.com',
        'AccountReference' => $phone_number,
        'TransactionDesc' => "Testing stk push on sandbox"
        ];
        
        $data_string = json_encode($curl_post_data);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        
        $curl_response = curl_exec($curl);
        Log::info($curl_response);
        return $curl_response;
        }





    /**
     * Generate an access token for every stk push
     * 
     * return [string] access_token
     */

    public function generateAccessToken(){

        $consumer_key = env('MPESA_CONSUMER_KEY', '');
        $consumer_secret = env('MPESA_CONSUMER_SECRET', '');
        $credentials = base64_encode($consumer_key . ":" . $consumer_secret);

        $url    = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";        
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $credentials));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);
        //$curl_info = curl_getinfo($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $access_token = json_decode($curl_response);

        $token= $access_token->access_token;
        Log::info('URL fxn tkn '.$token);
   
    return $token;
}



    // Access Token Alternative
    


    // public function generateAccessToken(){


    //     $token_m=DB::table('mpesa_tokens')->limit(1)->get();

    //     if($token_m) {
    //         foreach ($token_m as $x) {
    //             $token = $x->access_token;
    //        }

    //     }
    //     else {


    //         $consumer_key = 'oeazFs2H1ywGrmGAw0FqUzEOrHyPVzVw';
    //         $consumer_secret = 'DxpO6qlcsKMABZK8';
    //         $credentials = base64_encode($consumer_key . ":" . $consumer_secret);

    //         $url    = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
            

    //         $url = "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
    //         $curl = curl_init();

    //         curl_setopt($curl, CURLOPT_URL, $url);
    //         curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $credentials));
    //         curl_setopt($curl, CURLOPT_HEADER, false);
    //         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    //         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    //         $curl_response = curl_exec($curl);
    //         //$curl_info = curl_getinfo($curl);
    //         $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    //         $access_token = json_decode($curl_response);
    //         // Log::info($access_token);
    //         $token= $access_token->access_token;
    //         Log::info('URL fxn tkn '.$token);
    //     }
    //     return $token;
    // }

    /**
     * Mpesa callback, gives response which is then stored in the DB
     */
    public function mpesaCallback( Request $request ){

        $reciept_number     = $request['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
        Log::info( $reciept_number );
        $transaction_date   = $request['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'];
        Log::info( $transaction_date );
        $phone_number       = $request['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
        Log::info( $phone_number );

        $mpesa_response = DB::table('payments')
                            ->insert([
                                'phoneno' => $phone_number,
                                'mpesacode' => $reciept_number,
                                'created_at' => $transaction_date,                                  
                            ]);
        
        
        $message = "test mpesa confirmation";
        $offerCode = "001030900869"; 
        $cpId = 253 ; 
        $linkId = '';
        $this->sendConfirmationSMS( $phone_number, $message, $offerCode, $cpId, $linkId );

            return $request;
        
    }

    public function confirmationMpesa( Request $request ){
        Log::info("confirmation mpesa". $request );
    }

    public function validationMpesa( Request $request ){
        Log::info( "validation mpesa" . $request );
    }

    public function registerMpesaUrls(){

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '. $this->generateAccessToken()));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
            'ShortCode' => "600141",
            'ResponseType' => 'Completed',
            'ConfirmationURL' => "https://c52e5ec177a8.ngrok.io/api/confirmation",
            'ValidationURL' => "https://c52e5ec177a8.ngrok.io/api/validation"
        )));
        $curl_response = curl_exec($curl);
        echo $curl_response;
    }

    /**
     * Send confirmation SMS when user has paid
     */
    public function sendConfirmationSMS( $phone_number, $message, $offerCode, $cpId, $linkId ){
        
        $token = $this->GenerateToken();
        Log::info( $token );
        $phone = $phone_number;
        $message = $message;
        $url12 = 'https://dsvc.safaricom.com:9480/api/auth/login';
        $timeStamp =  date("YdmGis");
        $sms = 'API';
        $uniqueId = $phone.'_'.$timeStamp;
        $LinkId=$linkId;
        $OfferCode=$offerCode;
        $CpId=$cpId;
        $data='{
					                        "requestId":"'.$uniqueId.'",					                    					                
                                            "requestTimeStamp": "'.date("YdmGis").'", 
                                            "channel": "'.$sms.'",   
                                            "sourceAddress": "224.223.10.27",									                                      
                                            "requestParam": 
                                              {
                                                "data": 
                                                [
                                                {
                                                    "name": "LinkId",
                                                    "value":"'.$LinkId.'"
                                                  },
                                                  
                                                  {
                                                    "name": "OfferCode",
                                                    "value":"'.$OfferCode.'"
                                                  },
                                                  {
                                                    "name": "Msisdn",
                                                    "value": "'.$phone.'"
                                                  },
                                                    {
                                                    "name": "Content",
                                                        "value": "'.$message.'"
                                                      },
                                                  {
                                                    "name": "CpId",
                                                    "value":"'.$CpId.'"
                                                  }
                                                ]
                                              },
                                              "operation": "SendSMS"
                                            }';

                                    $data_strings12=$data;
                                    Log::info('req '.$data_strings12);
                                    $ch = curl_init($url12);

                                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_strings12);
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: application/json',
                                            'X-Requested-With: XMLHttpRequest',
                                            'X-Authorization:Bearer ' . $token
                                        )
                                    );

                                    $results12 = curl_exec($ch);
                                    Log::info( $results12 );
                                    
    }

    public function GenerateToken(){
        try {
            $username = "amwaytech_apiuser";
            $password = "AMWAYTECH_APIUSER@ps2545";

            $url12 = "https://dsvc.safaricom.com:9480/api/auth/login";

            $data12 = array(
                "username" => $username,
                "password" => $password
            );

            $data_strings12 = json_encode($data12);
            $ch = curl_init($url12);

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_strings12);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'X-Requested-With: XMLHttpRequest'
                )
            );
            $results12 = curl_exec($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            $objs12 = json_decode($results12,true);
            $token=$objs12['token'];
            Log::info('token '.$token);
            $refreshToken = $objs12['refreshToken'];


        }
        catch(\Exception $e)
        {
            $token=$e->getMessage();
        }

        $temporary_token = new mpesa_token([
            'access_token' => $token,                      
        ]);

        $temporary_token->save();

        return $token;
    }

    public function parsePhoneNumber($phone_number){
        $number = "";

        if(strlen($phone_number) == 12){ //254722000000

            $number = substr($phone_number,3,11);

        }else if(strlen($phone_number) == 10){ //0722000000
            $number = substr($phone_number,1,9);

        } else if(strlen($phone_number) == 9){ //722000000
            $number = $phone_number;

        } 

        return $number;

    }





    public function transactionpayment( Request $request ){

        $values = $request->except(['_token']);
        // dd($values);
        $phone_number = $request->clientNumber; 
        $amount =   $request->total; 
        $phone_number = substr($phone_number, -9);
        $phone_number = 254 . $phone_number;
        
        $this->customerMpesaSTKPush($phone_number, $amount);
        
        Tdetails::where('id', '=', $values['orderId'])
                ->update(['transactioncode' => 'mpesaCode']);

        return redirect('/home');

    }
}
