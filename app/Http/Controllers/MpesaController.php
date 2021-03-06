<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DateTime;

use Log;
use DB;
use Auth;

use App\Clients;
use App\User;
use App\Tdetails;
use App\Vendors;
use App\Payments;
use App\mpesa_token;
use App\Jobs\Sms;

use Twilio\Rest\Client;

class MpesaController extends Controller
{
    /**
     * Lipa na M-PESA password
     * */
    public function lipaNaMpesaPassword(){

        $lipa_time              = Carbon::rawParse('now')->format('YmdHms');
        $passkey                = '9f202c6227ba12753d83b4cac5f376ca01ccce8556c4fb65b2e1050dc770848e';
        // $BusinessShortCode      = 174379;
        $BusinessShortCode = 4051259;
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




    private function customerMpesaSTKPush($phone_number, $amount, $trans_id){
        // $phone_number = 254700682679;
        // $amount = 1;
        // $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $curl = curl_init();
        
        curl_setopt( $curl, CURLOPT_URL, $url );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Content-Type:application/json','Authorization:Bearer '.$this->generateAccessToken()) );
        
        $curl_post_data = [
        
        //Fill in the request parameters with valid values
        'BusinessShortCode' => 4051259,
        'Password' => $this->lipaNaMpesaPassword(),
        'Timestamp' => Carbon::rawParse('now')->format('YmdHms'),
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $amount,
        'PartyA' => $phone_number, // replace this with your phone number
        'PartyB' => 4051259,
        'PhoneNumber' => $phone_number, // replace this with your phone number
        'CallBackURL' => 'https://supamallescrow.com/v1/escrow/transaction/confirmation',
        'AccountReference' => $trans_id,
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
        Log::info('generateAccessToken function reached');
        $consumer_key = env('MPESA_CONSUMER_KEY', '');
        $consumer_secret = env('MPESA_CONSUMER_SECRET', '');
        $credentials = base64_encode($consumer_key . ":" . $consumer_secret);

        $url    = "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        // $url ='https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $credentials));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);
        // $curl_info = curl_getinfo($curl);
        Log::info('curl response is: '. $curl_response);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $access_token = json_decode($curl_response);

        $token= $access_token->access_token;
        Log::info('generateAccessToken generated: '.$token);
   
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
        Log::info('Callback function engaged');

        if ($request['ResultCode'] == '1032') {
            Log::info('User cancelled Mpesa STK Push Request');
        }else{
            Log::info('Callback Request came through');
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
        // Log::info(implode( ",", $request->all() ));
        Log::info('Next Confirmation Log: ');
        Log::info($request->all());
        $transaction_type = $request['TransactionType'];
        $receipt_number = $request['TransID'];
        $transaction_date = $request['TransTime'];
        $firstName = $request['FirstName'];
        $lastName = $request['LastName'];
        $middleName = $request['MiddleName'];
        $amount = $request['TransAmount'];
        $status = $request['failed'];
        $name = $firstName." ".$middleName." ".$lastName;
        //$phone_acc = $request['BillRefNumber'];
        $trans_id = $request['BillRefNumber'];
        $phone_number = $request['MSISDN'];

        Log::info($trans_id);
        $user = DB::table('users')->where('phone_number','=',$phone_number)->first();

        // $resultCode = $request['Body']['stkCallback']['ResultCode'];

        // $date = strtotime(strval($transaction_date));
        // $dateFormat = date('Y-m-d H:i:s',$date);

        $trans_date = new DateTime($transaction_date);
        
        //Check if customer paid successfully
        if($receipt_number == ''|| $receipt_number == null ) {
            Log::info('User either cancelled Mpesa STK Push Request or has insufficient funds');
        }else{

            //Check whether it's paybill or stk push
            if($phone_number){
                    $tdetails = DB::table('tdetails')->where('id', $trans_id)->first();
                    Log::info("Details amount: ");
                    $t = $tdetails->transamount;
                    Log::info($t);
                    $tariff = $this->tariffs($t);

                    $amount_to_be_paid = $t + $tariff;

                    if($amount != $amount_to_be_paid){
                        $balance = $amount - $amount_to_be_paid;
                        Log::info("Balance Remaining: ");
                        Log::info($balance);
                    }

                    $update_mpesa_code = DB::table('payments')
                                        ->where('transactioncode', $trans_id)
                                        ->update([
                                            'mpesacode' => $receipt_number,
                                            'amount_paid' => $amount
                                        ]);

                    $update_paid_status = DB::table('tdetails')
                    ->where('id', $trans_id)
                    ->update([
                        'paid' => 1,
                        'transactioncode' => $receipt_number,
                    ]);

                    $update_reports_table = DB::table('reports')
                    ->where('transaction_id', $trans_id)
                    ->update([
                        'buyer_sent_amount' => $amount,
                        'buyer_sent_mpesa_code' => $receipt_number,
                    ]);


                    // $recipient = $phone_number;
                    // $recipient = substr($recipient, -9);
                    // $recipient = '+254' . $recipient;
                    // $message = 'You have made a deposit to SupamallEscrow for the amount of '.$amount;
                    // $this->send_sms($recipient, $message);

                    // $number = $phone_number;
                    // $number = substr($number, -9);
                    // $number = '0'.$number;
                    // $message = 'You have made a deposit to SupamallEscrow for the amount of '.$amount;
                    // $this->send($number, $message, "DEPTHSMS");

                    $t = DB::table('tdetails')
                            ->where('id', $trans_id)
                            ->first();

                    $vendor = DB::table('users')
                    ->where('id', $t->vendor_id)
                    ->first();

                    Log::info($vendor->phone_number);

                    $client = DB::table('users')
                    ->where('id', $t->client_id)
                    ->first();

                    $phone_number = $vendor->phone_number;
                    $phone_number = substr($phone_number, -9);
                    $phone_number = '0'.$phone_number;
                    $message = 'Hello '.$vendor->business_name.'.SupamallEscrow has received the payment made by '.$client->first_name.' for the Order ID '.$t->id.'. Please Initiate the delivery by the stipulated terms.';
                    $SID = 'DEPTHSMS';
                    Sms::dispatch($phone_number, $message, $SID )->onQueue('sms');

                    $phone_number = $client->phone_number;
                    $phone_number = substr($phone_number, -9);
                    $phone_number = '0'.$phone_number;
                    $message = 'Hello '.$client->first_name.'. SupamallEscrow has received the payment in the amount of '.$amount.' made from the number '.$phone_number.' for the Order ID '.$t->id.'. We have notified the vendor to initiate the delivery.';
                    $SID = 'DEPTHSMS';
                    Sms::dispatch($phone_number, $message, $SID )->onQueue('sms');

                    $update_report_table = DB::table('reports')
                    ->where('transaction_id', $trans_id)
                    ->update([
                        'sms_count' => 3
                    ]);


                }
                else{
                    //Paybill  Details
                    if(stripos($trans_id, '-')){
                                    $trans_id = str_replace("-", " ", $trans_id);
                                    Log::info("Paybill Trans ID: ");
                                    Log::info($trans_id);
                                }
                }
                return response()->json([
                        'ResultCode' => 0,
                        'ResultDesc' => "Accepted",
                        ]);                  
            }
        
        /*BidLeo Checks past this point*/    

        //Check if customer paid successfully
        // if($resultCode != 0 ) {
        //     Log::info('User either cancelled Mpesa STK Push Request or has insufficient funds');
        // }else{

        //     //Check whether it's paybill or stk push
        //     if($phone_number == $phone_acc){
        //         //STK Push
        //         $users_bids = DB::table('bid')->where('phone_number', $phone_number)->get();

        //         foreach($users_bids as $bids){
        //             if($bid->created_at->diffInSeconds($dateFormat) < 30 ){
        //                 $update_bid_status = DB::table('bid')
        //                             ->where('bid_unique_id', $bid->bid_unique_id)                                
        //                             ->update([
        //                                 'bid_status' => 'active',
        //                                 'mpesa_reciept' => $reciept_number,
        //                                 'mpesa_payment_date' => $dateFormat
        //                             ]);

        //                 $update_rewards = DB::table('users')
        //                                     ->where('phone_number', '=',$phone_number)
        //                                     ->update([
        //                                         'name' => $firstName.' '.$middleName.' '.$lastName,
        //                                         'rewards_wallet' => $this_user->rewards_wallet + 5
        //                                     ]);            
        //             }                
    
        //         }
                
        //         //Check If User Is Eligible
        //         if($specific_user != null && $specific_user->eligible  == false){
        //             //User Is Not Eligible but has now paid
        //             $update_user = DB::table('users')
        //             ->where('phone_number', $phone_number )
        //             ->update([
        //                 'name'      => $name,                                    
        //                 'eligible'  => true,
        //             ]);
        //         }else{

        //             $update_user = DB::table('users')
        //             ->where('phone_number', $phone_number )
        //             ->update([
        //                 'name'      => $name,                                                           
        //             ]);
        //         }
               

        //     }else{
        //         //Paybill                

        //         if(stripos($phone_acc, '-')){
        //             $phone_acc = str_replace("-", " ", $phone_acc);
        //         }

        //         $bidder_unique_id= substr( bin2hex( random_bytes( 12 ) ),  0, 12 );

        //         $password = Crypt::encrypt($phone_number. substr( bin2hex( random_bytes( 4 ) ),  0, 4 ));  

        //         if (stripos($phone_acc, 'BIKE') !== false) { //Case insensitive
        //             $item = DB::table('item')->where('item_category','=','BIKE')->where('status','=','available')->first();
        //         }else if(stripos($phone_acc, 'PHONE') !== false){
        //             $item = DB::table('item')->where('item_category','=','PHONE')->where('status','=','available')->first();
        //         }else if(stripos($phone_acc, 'SHOP') !== false){
        //             $item = DB::table('item')->where('item_category','=','VOUCHER')->where('status','=','available')->first();
        //         }

        //         if(stripos($phone_acc, 'MCJ') !== false){
        //             $affiliate = 'mcj';
        //         }else if(stripos($phone_acc, 'GHETTO') !== false){
        //             $affiliate = 'ghetto'; 
        //         }else if(stripos($phone_acc, 'TEN') !== false){
        //             $affiliate = 'ten';
        //         }else if(stripos($phone_acc, 'BAK') !== false){
        //             $affiliate = 'bak';
        //         }else if(stripos($phone_acc, 'JAMBO') !== false){
        //             $affiliate = 'jambo';
        //         }else{
        //             $affiliate = 'bidleo';
        //         }
                
        //         $bid_amount = (int) filter_var($phone_acc, FILTER_SANITIZE_NUMBER_INT);
        //         $bid_amount = round($bid_amount);
        //         $bid_unique_id = $item->item_category. substr( bin2hex( random_bytes( 6 ) ),  0, 6 );

        //         //Check for existing user
               
        //         if ($specific_user === null && $amount == '20') {
        //             //user doesn't exist

        //             if((int)$amount > 20){
        //                 $paybill_balance = (int)$amount - 20;

        //                 $new_user = new User([
        //                     'phone_number' => $phone_number,
        //                     'password' => $password,
        //                     'bidder_unique_id' => $bidder_unique_id,
        //                     'role' => 'bidder',
        //                     'rewards_wallet' => 5,
        //                     'paybill_balance' => $paybill_balance,
        //                     'eligible' => true,           
        //                 ]);
    
        //             } else{
        //                 $new_user = new User([
        //                     'phone_number' => $phone_number,
        //                     'password' => $password,
        //                     'bidder_unique_id' => $bidder_unique_id,
        //                     'role' => 'bidder',
        //                     'rewards_wallet' => 5,
        //                     'eligible' => true,           
        //                 ]);
        //             }
            
        //             $new_user->save();
            
        //             $new_bid = new Bid([
        //                     'auction_id' => $item->auction_id,
        //                     'bid_amount' =>$bid_amount,
        //                     'item_name' => $item->item_name,
        //                     'bidder' => $phone_number,
        //                     'bidder_name' => $firstName.' '.$middleName.' '.$lastName,
        //                     'affiliate' => $affiliate,
        //                     'bid_unique_id' => $bid_unique_id,
        //                     'bid_start_time' => Carbon::now(),
        //                     'item_unique_id' => $item->item_unique_id,
        //                     'item_category' => $item->item_category,
        //                     'bid_status' => 'active',
        //                     'mpesa_reciept' => $reciept_number,
        //                     'mpesa_payment_date' => $dateFormat
        //                 ]);
            
        //             $new_bid->save();

        //             $auction_id = $item->auction_id;

        //             $this->updateAuction($phone_number, $bid_amount, $auction_id);
        //         }else{

        //             if((int)$amount > 20){
        //                 $paybill_balance = (int)$amount - 20;
    
        //                 $update_paybill = DB::table('users')
        //                 ->where('phone_number', '=',$phone_number)
        //                 ->update([
        //                     'paybill_balance' => $this_user->paybill_balance + $paybill_balance
        //                 ]); 
        //             }                   

        //             $update_rewards = DB::table('users')
        //             ->where('phone_number', '=',$phone_number)
        //             ->update([
        //                 'rewards_wallet' => $this_user->rewards_wallet + 5
        //             ]); 

        //             $new_bid = new Bid([
        //                 'auction_id' => $item->auction_id,
        //                 'bid_amount' =>$bid_amount,
        //                 'item_name' => $item->item_name,
        //                 'bidder' => $phone_number,
        //                 'affiliate' => $affiliate,
        //                 'bid_unique_id' => $bid_unique_id,
        //                 'bid_start_time' => Carbon::now(),
        //                 'item_unique_id' => $item->item_unique_id,
        //                 'item_category' => $item->item_category,
        //                 'bid_status' => 'active',
        //                 'mpesa_reciept' => $reciept_number
        //             ]);
        
        //         $new_bid->save();

        //         $auction_id = $item->auction_id;

        //         $this->updateAuction($phone_number, $bid_amount, $auction_id);
        //         }

        //     }    

        // $message = "Mpesa Payment Succesfully Received.";              
        // $this->sendBulkSMS( $phone_number, $message );                        

        // return response()->json([
        //         'ResultCode' => 0,
        //         'ResultDesc' => "Accepted",
        //         ]);       
        //     }                         
                   
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
        if($request->itemCheckbox == null || $request->itemCheckbox == '')
        {
            //$sum = array_sum($request->itemCheckbox);
            $sum = $request->subtotal;
        

            // dd($request->all());

            $values = $request->except(['_token']);
            $phone_number = $request->clientNumber; 

            if($request->subtotal == $sum)
            {
                $amount = $request->total; 
                
                //dd('equal and total = '.$amount);

                $phone_number = substr($phone_number, -9);
                $phone_number = 254 . $phone_number;

                $trans_id = $request->orderId;
                
                $this->customerMpesaSTKPush($phone_number, $amount, $trans_id);
                
                Tdetails::where('id', '=', $values['orderId'])
                        ->update(['transactioncode' => 'mpesaCode']);
                    
                $transactioncode = $request->orderId;

                $pay = new Payments;
                $pay->transactioncode = $transactioncode;
                $pay->phoneno = $phone_number;
                $pay->mpesacode = '';
                $pay->amount_paid = 0;
                $pay->amount_due = 0;
                $pay->save();

                return redirect('/home');

            }

            if($request->total != $sum)
            {
                $tariff = 0;

                $total = $request->total;
                // $t = (intval($total) - ( intval($total) - intval($sum)));
                $t = $sum;
                $tariff = $this->tariffs($t);

                // dd('not equal and total = '. ($t + intval($tariff)) );

                $amount = $t + intval($tariff);

                // dd($amount);

                $phone_number = substr($phone_number, -9);
                $phone_number = 254 . $phone_number;

                $trans_id = $request->orderId;
                
                $this->customerMpesaSTKPush($phone_number, $amount, $trans_id);
                
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
        } else {
            return back();
        }

    }

    /**
     * Tariff setup function
     */
    private function tariffs($total_amount)
    {
        if($total_amount >= 1 && $total_amount <= 100)
        {
            $tariff = 28;
        }

        if($total_amount >= 101 && $total_amount <= 499)
        {
            $tariff = 83;
        }

        if($total_amount >= 500 && $total_amount <=1000)
        {
            $tariff = 89;
        }

        if($total_amount >= 1001 && $total_amount <= 1499)
        {
            $tariff = 105;
        }

        if($total_amount >= 1500 && $total_amount <= 2499)
        {
            $tariff = 110;
        }

        if($total_amount >= 2500 && $total_amount <= 3499)
        {
            $tariff = 159;
        }

        if($total_amount >= 3500 && $total_amount <= 4999)
        {
            $tariff = 181;
        }

        if($total_amount >= 5000 && $total_amount <= 7499)
        {
            $tariff = 232;
        }

        if($total_amount >= 7500 && $total_amount <= 9999)
        {
            $tariff = 265;
        }

        if($total_amount >= 10000 && $total_amount <= 14999)
        {
            $tariff = 347;
        }

        if($total_amount >= 15000 && $total_amount <= 19999)
        {
            $tariff = 370;
        }

        if($total_amount >= 20000 && $total_amount <= 24999)
        {
            $tariff = 386;
        }

        if($total_amount >= 25000 && $total_amount <= 29999)
        {
            $tariff = 391;
        }

        if($total_amount >= 30000 && $total_amount <= 34999)
        {
            $tariff = 396;
        }

        if($total_amount >= 35000 && $total_amount <= 39999)
        {
            $tariff = 570;
        }

        if($total_amount >= 40000 && $total_amount <= 44999)
        {
            $tariff = 575;
        }

        if($total_amount >= 45000 && $total_amount <= 49999)
        {
            $tariff = 580;
        }

        if($total_amount >= 50000 && $total_amount <= 69999)
        {
            $tariff = 623;
        }

        if($total_amount >= 70000 && $total_amount <= 150000)
        {
            $tariff = 628;
        }

        return $tariff;
    }



    /**
     * B2C Functions Start Here
     * 
     */

    public function getAccessToken()
    {
        // $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init($url);
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=utf8'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_USERPWD => env('MPESA_B2C_CONSUMER_KEY') . ':' . env('MPESA_B2C_CONSUMER_SECRET')
            )
        );
        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        // return $response;
        return $response->access_token;
    }


    public function b2cPassword()
    {
        $initiatorPassword = env('MPESA_B2C_INITIATOR_PASSWORD');
        // $certificate = env('MPESA_B2C_CERTIFICATE');
        $iv = substr( md5( "123sdfsdf4567812345678" ), 0, 16 );

        $certificate= file_get_contents('../cert/ProductionCertificate.cer');
        
        // $b2cPassword = base64_encode( openssl_encrypt ($initiatorPassword, 'AES-256-CTR', $certificate, true, $iv));
        $b2cPassword = base64_encode(openssl_public_encrypt($initiatorPassword,$encrypted,$certificate, OPENSSL_PKCS1_PADDING));

        return $b2cPassword;
    }

    public function encryptfxn(){
        
        //Directory location for the M-Pesa certificate
        // $g2PublicKey ="file:///etc/pki/tls/certs/DATA_BUNDLES/ApiCryptPublicOnly.cer";

        $g2PublicKey = file_get_contents('../cert/ProductionCertificate.cer');
        $data = json_decode(file_get_contents('php://input'), true);
        

        //security credentials
        $securityCredential = env('MPESA_B2C_INITIATOR_PASSWORD');


        $try = openssl_public_encrypt($securityCredential, $encrypted, $g2PublicKey, OPENSSL_PKCS1_PADDING);

        if ($try) {
            //echo base64_encode($encrypted);
            //step 1 RSA encryption 
            //@TODO do URL encoding for $g2Encrypted???
            $g2Encrypted = base64_encode($encrypted);

            $response = $g2Encrypted;

        } else {
            $response = [
                'success' => false,
                'error' => 'step 1: G2 RSA failed' //which step has failed
            ];

        }

        return json_encode($response);

    }

    public function b2cRequest($phone_number, $amount, $trans_id)
    {
        $curl_post_data = array(
            'OriginatorConversationID' => $trans_id,
            'InitiatorName' => env('MPESA_B2C_INITIATOR_NAME'),
            'SecurityCredential' => $this->encryptfxn(),
            'CommandID' => 'BusinessPayment',
            'Amount' => $amount,
            'PartyA' => 3029009,
            'PartyB' => $phone_number,
            'Remarks' => 'Transaction Complete',
            'QueueTimeOutURL' => 'https://supamallescrow.com/v1/escrow/b2c/queue',
            'ResultURL' => 'https://supamallescrow.com/v1/escrow/b2c/result',
            'Occasion' => 'Payment by SupamallEscrow For Transaction Id:'.$trans_id
          );
        
        Log::info('Security Credential is: '. $curl_post_data['SecurityCredential']);
        Log::info('Party B is: '. $curl_post_data['PartyB']);
        // $url = 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
        $url = 'https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                    CURLOPT_URL => $url,
                    CURLOPT_HTTPHEADER => array('Content-Type:application/json','Authorization:Bearer '.$this->getAccessToken()),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($curl_post_data)
                )
        );
        $curl_response = curl_exec($curl);
        curl_close($curl);
        $res = $curl_response;
        Log::info($res);
        Log::info('ID: ');
        $ids = explode( ',', $res );
        $its = explode( ': ', $ids[1] );
        $it = str_replace('"', "", $its[1]);
        Log::info($it[1]);

        $update_reports_table = DB::table('reports')
                    ->where('transaction_id', $trans_id)
                    ->update([
                        'OCI' => $it,
                    ]);

        return $res;
    }

    public function b2cCallback(Request $request){
        Log::info('B2C endpoint hit');
        Log::info($request->all());
        $counter = 0;
        $dets = [];
        foreach(($request->all()) as $array){    
            foreach($array as $key=>$value){
                $counter++;
                if($counter == 7){
                    foreach($value as $key=>$v){
                        foreach($v as $key=>$detail){
                            foreach($detail as $key=>$d){
                                array_push($dets, $d);
                            }
                        }
                    }
                }
            }
        }
        // Log::info('B2C Result Parameters: '.implode(",",$dets));
        Log::info('ID: ');
        // Log::info($request->Result['OriginatorConversationID']);
        $callback_id = $request->Result['OriginatorConversationID'];
        Log::info($callback_id);
        $rep = DB::table('reports')->where('OCI', $callback_id)->first();
        Log::info($rep->transaction_id);

        $receipt_number = $dets[3];
        $transaction_date = $dets[7];
        $receiver_details = $dets[5];
        $amount = $dets[1];

        $created = Carbon::now();
        $store_settlement = DB::table('settlements')
                                            ->insert([
                                                'amount' => $amount,
                                                'receiver_details' => $receiver_details,
                                                'mpesacode' => $receipt_number,
                                                'created_at' => $created
                                            ]);

        $update_reports_table = DB::table('reports')
        ->where('OCI', '=', $callback_id)
        ->update([
            'escrow_sent_mpesa_code' => $receipt_number,
            'vendor_received_amount' => $amount
        ]);

        return [
            'ResultCode' => 0,
            'ResultDesc' => 'Accept Service',
            'ThirdPartyTransID' => rand(3000, 10000)
        ];
    }



    public function acceptDelivery(Request $request) 
    {
        // dd($request->all());
        $tdetails_check = DB::table('tdetails')
                                    ->where('id', $request->input('orderId'))
                                    ->first();

        if ($tdetails_check->closed == 1)
        {
            return redirect()->route('deliveries')->with('success', 'Delivery Has Been Confirmed and Payment Delivered');   
        }


        if($request->has('acceptDelivery'))
        {
            
            if($request->itemCheckbox != null)
                {
                    $sum = array_sum($request->itemCheckbox);
                    // dd($sum);

                    //Doing a check if all items have been accepted or rejected then prompt the vendor accordingly
                    
                    if($request->subtotal == $sum)
                    {
                        // dd('Entire Delivery was accepted');
                        $update_tdetails_table = DB::table('tdetails')
                                    ->where('id', $request->input('orderId'))
                                    ->update([
                                    'delivered' => '1',
                                    'closed' => '1'                                                                 
                            ]);

                        $amount_due = ($request->subtotal) - $sum;

                        $update_payments_table = DB::table('payments')
                                    ->where('transactioncode', $request->input('orderId'))
                                    ->update([
                                    'amount_due' => $amount_due,                                                          
                                ]);

                        $transaction = Tdetails::where('id', $request->input('orderId'))
                                        ->first();

                        $email = Auth::user()->email;
                        // dd($transaction);
                        $vendor = User::where('id', $transaction->vendor_id)->first();
                        
                        $client = User::where('id', $transaction->client_id)->first();

                        $data = [
                            'client_name' => $client->first_name,
                            'client_phone' => $client->phone_number,
                            'transaction_details' => $transaction->transdetail,
                            'delivery_location' => $transaction->deliverylocation,
                            'delivery_time' => $transaction->deliverytime,
                            'delivery_fee' => $transaction->deliveryamount,
                            'delivery_fee_handler' => $transaction->delivery_fee_handler,
                        ];
                        // Mail::to($email)->send(new DeliveryMail($data));
                        
                        //Vendor Settlement
                        $phone_number = $vendor->phone_number;
                        $phone_number = substr($phone_number, -9);
                        $phone_number = 254 . $phone_number;

                        $amount = $request->subtotal;
                        $trans_id = $request->input('orderId');
                        $this->b2cRequest($phone_number, $amount, $trans_id);

                        $t = $request->subtotal;

                        $tariff = $this->tariffs($t);

                        if($request->subtotal < 1000)
                        {
                            $mpesa_charge = 15.27;
                        }
                        else{
                            $mpesa_charge = 22.40;
                        }

                        $escrow_fee = ($tariff - $mpesa_charge - 2);

                        $update_reports_table = DB::table('reports')
                        ->where('transaction_id', $request->input('orderId'))
                        ->update([
                            'mpesa_charge' => $mpesa_charge,
                            'escrow_fee' => $escrow_fee,
                            'buyer_received_amount' => 'N/A',
                            'transaction_completion_time' => Carbon::now(),
                            'transaction_status' => 'completed'
                        ]);

                        return redirect()->route('deliveries')->with('success', 'Delivery Confirmed');

                    } else{
                            // dd('Entire Delivery was not accepted');
                            $trans_details = $request->all();

                            $update_tdetails_table = DB::table('tdetails')
                                        ->where('id', $request->input('orderId'))
                                        ->update([
                                        'delivered' => '1',
                                        'closed' => '1'                                                                 
                                ]);

                            $amount_due = ($request->subtotal) - $sum;
                            // dd($amount_due);

                            $update_payments_table = DB::table('payments')
                                        ->where('transactioncode', $request->input('orderId'))
                                        ->update([
                                        'amount_due' => $amount_due,                                                          
                                    ]);

                            

                            $transaction = Tdetails::where('id', $request->input('orderId'))
                                            ->first();

                            $email = Auth::user()->email;
                            // dd($transaction);
                            $vendor = User::where('id', $transaction->vendor_id)->first();
                            
                            $client = User::where('id', $transaction->client_id)->first();

                            $data = [
                                'client_name' => $client->first_name,
                                'client_phone' => $client->phone_number,
                                'transaction_details' => $transaction->transdetail,
                                'delivery_location' => $transaction->deliverylocation,
                                'delivery_time' => $transaction->deliverytime,
                                'delivery_fee' => $transaction->deliveryamount,
                                'delivery_fee_handler' => $transaction->delivery_fee_handler,
                            ];
                            // Mail::to($email)->send(new DeliveryMail($data));

                            //Client Settlement
                            $phone_number = $client->phone_number;
                            $phone_number = substr($phone_number, -9);
                            $phone_number = 254 . $phone_number;

                            $amount = $amount_due;
                            $trans_id = $request->input('orderId');
                            $this->b2cRequest($phone_number, $amount_due, $trans_id);

                            //Vendor Settlement
                            $phone_number = $vendor->phone_number;
                            $phone_number = substr($phone_number, -9);
                            $phone_number = 254 . $phone_number;

                            $amount = (($request->subtotal) - $amount_due);
                            $trans_id = $request->input('orderId');
                            $this->b2cRequest($phone_number, $amount, $trans_id);
                            
                            return view('Delivery.rejectDelivery', compact('trans_details'))->with('alertMsg', 'Not all purchases were accepted upon delivery');
                    }
                    
                }
                else{
                    return redirect()->back()->with('alert', 'Accept at least one or all deliveries using the accept checkboxes!');
                }
        }

        if($request->has('rejectDelivery')) 
        {   
            //Entire Delivery was rejected
            
            $transaction = Tdetails::where('id', $request->input('orderId'))
                                        ->first();
            $dtime = new DateTime($transaction->deliverytime,);
            $now = new DateTime();
            $diff = now()->diffInHours($transaction->created_at);

            //Remember to activate
            // if($diff < intval($transaction->delivery_time))
            // {
            //     return redirect()->back()->with('success', "There's still time, be patient!");
            // }

            $tdetails_check = DB::table('tdetails')
                                    ->where('id', $request->input('orderId'))
                                    ->first();

            if ($tdetails_check->closed == 1)
            {
                return redirect()->route('deliveries')->with('success', 'Rejection Has Already  Been Confirmed');   
            }
            
            $update_tdetails_table = DB::table('tdetails')
                                    ->where('id', $request->input('orderId'))
                                    ->update([
                                    'delivered' => '1',
                                    'closed' => '1'                                                                 
                            ]);

            $trans_details = $request->all();
            // dd($trans_details);
            $transaction = Tdetails::where('id', $request->input('orderId'))
                                        ->first();

            $client = User::where('id', $transaction->client_id)->first();

            //Client Settlement
            $phone_number = $client->phone_number;
            $phone_number = substr($phone_number, -9);
            $phone_number = 254 . $phone_number;

            $amount = $request->subtotal;
            $trans_id = $request->input('orderId');
            $this->b2cRequest($phone_number, $amount, $trans_id);

            $t = $request->subtotal;

            $tariff = $this->tariffs($t);

            if($request->subtotal < 1000)
            {
                $mpesa_charge = 15.27;
            }
            else{
                $mpesa_charge = 22.40;
            }

            $escrow_fee = ($tariff - $mpesa_charge - 4);

            $update_reports_table = DB::table('reports')
            ->where('transaction_id', $request->input('orderId'))
            ->update([
                'mpesa_charge' => $mpesa_charge,
                'escrow_fee' => $escrow_fee,
                'transaction_completion_time' => Carbon::now(),
                'transaction_status' => 'terminated'
            ]);

            return view('Delivery.rejectDelivery', compact('trans_details'));
        }
        
    }

    /**
     * Sending SMS via Twilio
     * 
     */
    public function send_sms($recipient, $message)
    {

        // // Your Account SID and Auth Token from twilio.com/console
        // $account_sid = 'AC3261703f9f12fe402d7c164af1e0834b';
        // $auth_token = '016ca55f0efd7b4494d5f2fb6467788a';
        // In production, these should be environment variables. E.g.:
        $account_sid = $_ENV["TWILIO_AUTH_SID"];
        $auth_token = $_ENV["TWILIO_AUTH_TOKEN"];

        // A Twilio number you own with SMS capabilities
        $twilio_number = "+19362460202";
        // $recipient = '+254704618977';
        // $message = "Escrow sent this message";

        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            $recipient,
            array(
                'from' => $twilio_number,
                'body' => $message
            )
        );
    }


     /**
     * UjumbeSMS Functions start here
     */

    public function prepare($data)
    {

        $data = [
            "data" => [[
                "message_bag" => [
                    "numbers" => $data['numbers'],
                    "message" => $data['message'],
                    "sender" => $data['sender'],
                ]
            ]]
        ];

        Log::info($data);

        $sms_data = json_encode($data);
        $url = 'https://ujumbesms.co.ke/api/messaging';

        Log::info($sms_data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $sms_data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($sms_data),
            'X-Authorization: ZTQ1ZGIwNjFkMGFhZDQyOTQ3OTBmYTYyMGJlYjYy',
            'email: abraham.nyabera@msimboit.net'
        ));


        $response = curl_exec($curl);
        Log::info($response);

        if ($response === false) {
            $err = 'Curl error: ' . curl_error($curl);
            curl_close($curl);
            Log::info($err);
            return $err;
        } else {
            curl_close($curl);
            Log::info($response);
            return $response;
        }
    }

    /**
     * @param $numbers = phone numbers separated with commas
     * @param $message
     * @param $sender = The sender id assigned by ujumbeSMS eg DepthSMS
     */
    public function send($numbers, $message, $sender)
    {

        $data = [
            "numbers" => $numbers,
            "message" => $message,
            "sender" => $sender
        ];
        $this->prepare($data);

    }

}
