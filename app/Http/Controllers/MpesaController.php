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
use App\Payments;
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
        'CallBackURL' => 'https://phplaravel-607367-1966954.cloudwaysapps.com/v1/escrow/transaction/confirmation',
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

        if ($request['ResultCode'] == '1032') {
            Log::info('User cancelled Mpesa STK Push Request');
        }else{
            Log::info($request->all());

        $reciept_number     = $request['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
        Log::info( $reciept_number );
        $transaction_date   = $request['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'];
        Log::info( $transaction_date );
        $phone_number       = $request['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
        Log::info( $phone_number );
        
        if (User::where('phone_number', '=', $phone_number)->exists()) {
            // $mpesa_response = DB::table('users')
            //                     ->where('phone_number', $phone_number )
            //                     ->update([
            //                         'mpesa_transaction_codes' => $reciept_number,
            //                         'mpesa_transaction_dates' => $transaction_date,                                  
            //                     ]);
        
        
        $message = "Mpesa Payment Received Successfully.";
        
        $this->sendBulkSMS($phone_number, $message);

        return $request;

         }else{

            // $mpesa_response = DB::table('users')
            //                     ->where('phone_number', $phone_number )
            //                     ->update([
            //                         'mpesa_transaction_codes' => $reciept_number,
            //                         'mpesa_transaction_dates' => $transaction_date,
            //                         'eligible'             => true,
            //                     ]);
        
        
        $message = "Mpesa Payment Succesfully Received.";              
        $this->sendBulkSMS( $phone_number, $message );

        return $request;
         }
        }
        
    }

    public function confirmationMpesa( Request $request ){
        Log::info("confirmation mpesa". $request );
        $reciept_number = $request['TransID'];
        $transaction_date = $request['TransTime'];
        $firstName = $request['FirstName'];
        $lastName = $request['LastName'];
        $middleName = $request['MiddleName'];
        $amount = $request['TransAmount'];
        $status = $request['failed'];
        $name = $firstName." ".$middleName." ".$lastName;
        $phone_acc = $request['BillRefNumber'];
        $phone_number = $request['MSISDN'];

        $user = DB::table('users')->where('phone_number','=',$phone_number)->first();

        $resultCode = $request['Body']['stkCallback']['ResultCode'];

        $date = strtotime(strval($transaction_date));
        $dateFormat = date('Y-m-d H:i:s',$date);

        $user_latest_payment = DB::table('payments')
                                ->where('phoneno', $phone_number)
                                ->orderBy('created_at', 'desc')
                                ->first();

        if((int)$amount < 20){
            $message = "You have paid an amount less than 20 bob. Your bid shall not be accepted.";              
            $this->sendBulkSMS( $phone_number, $message );   
        }

        //Check if customer paid successfully
        if($resultCode != 0 ) {
            Log::info('User either cancelled Mpesa STK Push Request or has insufficient funds');
        }else{

            //Check whether it's paybill or stk push
            if($phone_number == $phone_acc){
                //STK Push
                $users_bids = DB::table('bid')->where('phone_number', $phone_number)->get();

                foreach($users_bids as $bids){
                    if($bid->created_at->diffInSeconds($dateFormat) < 30 ){
                        $update_bid_status = DB::table('bid')
                                    ->where('bid_unique_id', $bid->bid_unique_id)                                
                                    ->update([
                                        'bid_status' => 'active',
                                        'mpesa_reciept' => $reciept_number,
                                        'mpesa_payment_date' => $dateFormat
                                    ]);

                        $update_rewards = DB::table('users')
                                            ->where('phone_number', '=',$phone_number)
                                            ->update([
                                                'name' => $firstName.' '.$middleName.' '.$lastName,
                                                'rewards_wallet' => $this_user->rewards_wallet + 5
                                            ]);            
                    }                
    
                }
                
                //Check If User Is Eligible
                if($specific_user != null && $specific_user->eligible  == false){
                    //User Is Not Eligible but has now paid
                    $update_user = DB::table('users')
                    ->where('phone_number', $phone_number )
                    ->update([
                        'name'      => $name,                                    
                        'eligible'  => true,
                    ]);
                }else{

                    $update_user = DB::table('users')
                    ->where('phone_number', $phone_number )
                    ->update([
                        'name'      => $name,                                                           
                    ]);
                }
               

            }else{
                //Paybill                

                if(stripos($phone_acc, '-')){
                    $phone_acc = str_replace("-", " ", $phone_acc);
                }

                $bidder_unique_id= substr( bin2hex( random_bytes( 12 ) ),  0, 12 );

                $password = Crypt::encrypt($phone_number. substr( bin2hex( random_bytes( 4 ) ),  0, 4 ));  

                if (stripos($phone_acc, 'BIKE') !== false) { //Case insensitive
                    $item = DB::table('item')->where('item_category','=','BIKE')->where('status','=','available')->first();
                }else if(stripos($phone_acc, 'PHONE') !== false){
                    $item = DB::table('item')->where('item_category','=','PHONE')->where('status','=','available')->first();
                }else if(stripos($phone_acc, 'SHOP') !== false){
                    $item = DB::table('item')->where('item_category','=','VOUCHER')->where('status','=','available')->first();
                }

                if(stripos($phone_acc, 'MCJ') !== false){
                    $affiliate = 'mcj';
                }else if(stripos($phone_acc, 'GHETTO') !== false){
                    $affiliate = 'ghetto'; 
                }else if(stripos($phone_acc, 'TEN') !== false){
                    $affiliate = 'ten';
                }else if(stripos($phone_acc, 'BAK') !== false){
                    $affiliate = 'bak';
                }else if(stripos($phone_acc, 'JAMBO') !== false){
                    $affiliate = 'jambo';
                }else{
                    $affiliate = 'bidleo';
                }
                
                $bid_amount = (int) filter_var($phone_acc, FILTER_SANITIZE_NUMBER_INT);
                $bid_amount = round($bid_amount);
                $bid_unique_id = $item->item_category. substr( bin2hex( random_bytes( 6 ) ),  0, 6 );

                //Check for existing user
               
                if ($specific_user === null && $amount == '20') {
                    //user doesn't exist

                    if((int)$amount > 20){
                        $paybill_balance = (int)$amount - 20;

                        $new_user = new User([
                            'phone_number' => $phone_number,
                            'password' => $password,
                            'bidder_unique_id' => $bidder_unique_id,
                            'role' => 'bidder',
                            'rewards_wallet' => 5,
                            'paybill_balance' => $paybill_balance,
                            'eligible' => true,           
                        ]);
    
                    } else{
                        $new_user = new User([
                            'phone_number' => $phone_number,
                            'password' => $password,
                            'bidder_unique_id' => $bidder_unique_id,
                            'role' => 'bidder',
                            'rewards_wallet' => 5,
                            'eligible' => true,           
                        ]);
                    }
            
                    $new_user->save();
            
                    $new_bid = new Bid([
                            'auction_id' => $item->auction_id,
                            'bid_amount' =>$bid_amount,
                            'item_name' => $item->item_name,
                            'bidder' => $phone_number,
                            'bidder_name' => $firstName.' '.$middleName.' '.$lastName,
                            'affiliate' => $affiliate,
                            'bid_unique_id' => $bid_unique_id,
                            'bid_start_time' => Carbon::now(),
                            'item_unique_id' => $item->item_unique_id,
                            'item_category' => $item->item_category,
                            'bid_status' => 'active',
                            'mpesa_reciept' => $reciept_number,
                            'mpesa_payment_date' => $dateFormat
                        ]);
            
                    $new_bid->save();

                    $auction_id = $item->auction_id;

                    $this->updateAuction($phone_number, $bid_amount, $auction_id);
                }else{

                    if((int)$amount > 20){
                        $paybill_balance = (int)$amount - 20;
    
                        $update_paybill = DB::table('users')
                        ->where('phone_number', '=',$phone_number)
                        ->update([
                            'paybill_balance' => $this_user->paybill_balance + $paybill_balance
                        ]); 
                    }                   

                    $update_rewards = DB::table('users')
                    ->where('phone_number', '=',$phone_number)
                    ->update([
                        'rewards_wallet' => $this_user->rewards_wallet + 5
                    ]); 

                    $new_bid = new Bid([
                        'auction_id' => $item->auction_id,
                        'bid_amount' =>$bid_amount,
                        'item_name' => $item->item_name,
                        'bidder' => $phone_number,
                        'affiliate' => $affiliate,
                        'bid_unique_id' => $bid_unique_id,
                        'bid_start_time' => Carbon::now(),
                        'item_unique_id' => $item->item_unique_id,
                        'item_category' => $item->item_category,
                        'bid_status' => 'active',
                        'mpesa_reciept' => $reciept_number
                    ]);
        
                $new_bid->save();

                $auction_id = $item->auction_id;

                $this->updateAuction($phone_number, $bid_amount, $auction_id);
                }

            }    

        $message = "Mpesa Payment Succesfully Received.";              
        $this->sendBulkSMS( $phone_number, $message );                        

        return response()->json([
                'ResultCode' => 0,
                'ResultDesc' => "Accepted",
                ]);       
            }                         
                   
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
            
        $transactioncode = $request->orderId;

        $pay = new Payments;
        $pay->transactioncode = $transactioncode;
        $pay->phoneno = $phone_number;
        $pay->mpesacode = '';
        $pay->save();

        return redirect('/home');

    }
}
