<?php

namespace App\Http\Controllers;

use App\MpesaTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class MpesaController extends Controller
{

    /**
     * Lipa na M-PESA password
     * */

    public function lipaNaMpesaPassword()
    {
        $lipa_time = Carbon::rawParse('now')->format('YmdHms');
        $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        $BusinessShortCode = 174379;
        $timestamp =$lipa_time;

        $lipa_na_mpesa_password = base64_encode($BusinessShortCode.$passkey.$timestamp);
        return $lipa_na_mpesa_password;
    }


    /**
     * Lipa na M-PESA STK Push method
     * */

    public function customerMpesaSTKPush()
    {
        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateAccessToken()));


        $curl_post_data = [
            //Fill in the request parameters with valid values
            'BusinessShortCode' => 4060000,
            'Password' => $this->lipaNaMpesaPassword(),
            'Timestamp' => Carbon::rawParse('now')->format('YmdHms'),
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => 1,
            'PartyA' => 254700682679, // replace this with your phone number
            'PartyB' => 4060000,
            'PhoneNumber' => 254700682679, // replace this with your phone number
            'CallBackURL' => 'http://127.0.0.1:8000/api/v1/escrow/stk/push',
            'AccountReference' => "Escrow Test",
            'TransactionDesc' => "Testing stk push on sandbox for Escrow"
        ];

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);

        return $curl_response;
    }


    /**
     * Generate an access token for every stk push
     * 
     * return [string] access_token
     */
    public function generateAccessToken()
    {
        $consumer_key="oeazFs2H1ywGrmGAw0FqUzEOrHyPVzVw";
        $consumer_secret="DxpO6qlcsKMABZK8";
        $credentials = base64_encode($consumer_key.":".$consumer_secret);

        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials));
        curl_setopt($curl, CURLOPT_HEADER,false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);
        $access_token=json_decode($curl_response);
        return $access_token->access_token;
    }


    /**
     * Mpesa callback, gives response which is then stored in the DB
     */
    public function mpesaCallback( Request $request ){

        $resultCode = $request['Body']['stkCallback']['ResultCode'];     
	
    	if($resultCode == 0){

            $mpesaCallBackParams = $request;
            $items = $mpesaCallBackParams['Body']['stkCallback']['CallbackMetadata']['Item'];
            $phone_number = "";
            $reciept_number = "";
            $transaction_date = "";

            foreach($items as $arr){
                $val =  $arr['Name'];
                if($val == 'MpesaReceiptNumber'){
                    $reciept_number = $arr['Value'];
                }else if($val == 'TransactionDate'){
                    $transaction_date = $arr['Value'];
                }else if($val == 'PhoneNumber'){
                    $phone_number = $arr['Value'];
                }
            }

           log::info("M-PesaCallBack: Code=".$resultCode.",Receipt=".$reciept_number.",Date=".$transaction_date.",Phone=".$phone_number);
            
    	        // $mpesa_response = DB::table('eligible_participants')
                //                     ->where('phone_number', '$phone_number' )
                //                     ->update([
                //                         'mpesa_reciept_number' => $reciept_number,
                //                         'transaction_date'     => $transaction_date,
                //                         'eligible'             => true,
                //                     ]);
            
            
            	$message = "The Big Quiz Show Payment Successfully Received";
            	$offerCode = "001030900869"; 
            	$cpId = 253 ; 
            	$linkId = '';
            	//$del_participant = DB::table('participants')->where('phone_number', $phone_number)->delete();
            	//$this->sendConfirmationSMS( $phone_number, $message, $offerCode, $cpId, $linkId );
                $this->sendConfirmationSMS( $phone_number, $message);
    	}
        //Not possible since we do not have teh phone number
        /*else{
            $phone_number = $request['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
    		$message = "Quiz Payment Failed. Please try again.";
            $offerCode = "001030900869"; 
            $cpId = 253 ; 
            $linkId = '';
            $del_participant = DB::table('participants')->where('phone_number', $phone_number)->delete();
            //$this->sendConfirmationSMS( $phone_number, $message, $offerCode, $cpId, $linkId );
            $this->sendConfirmationSMS( $phone_number, $message);
    	}*/

        return $request;
    }

    public function confirmationMpesa( Request $request ){
        Log::info("confirmation mpesa". $request );
    }

    public function validationMpesa( Request $request ){
        Log::info( "validation mpesa" . $request );
    }





    

    /**
     * M-pesa Transaction confirmation method, we save the transaction in our databases
     */

    public function mpesaConfirmation(Request $request)
    {
        $content=json_decode($request->getContent());

        $mpesa_transaction = new MpesaTransaction();
        $mpesa_transaction->TransactionType = $content->TransactionType;
        $mpesa_transaction->TransID = $content->TransID;
        $mpesa_transaction->TransTime = $content->TransTime;
        $mpesa_transaction->TransAmount = $content->TransAmount;
        $mpesa_transaction->BusinessShortCode = $content->BusinessShortCode;
        $mpesa_transaction->BillRefNumber = $content->BillRefNumber;
        $mpesa_transaction->InvoiceNumber = $content->InvoiceNumber;
        $mpesa_transaction->OrgAccountBalance = $content->OrgAccountBalance;
        $mpesa_transaction->ThirdPartyTransID = $content->ThirdPartyTransID;
        $mpesa_transaction->MSISDN = $content->MSISDN;
        $mpesa_transaction->FirstName = $content->FirstName;
        $mpesa_transaction->MiddleName = $content->MiddleName;
        $mpesa_transaction->LastName = $content->LastName;
        $mpesa_transaction->save();


        // Responding to the confirmation request
        $response = new Response();
        $response->headers->set("Content-Type","text/xml; charset=utf-8");
        $response->setContent(json_encode(["C2BPaymentConfirmationResult"=>"Success"]));


        return $response;
    }


    /**
     * M-pesa Register Validation and Confirmation method
     */
    public function mpesaRegisterUrls()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '. $this->generateAccessToken()));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
            'ShortCode' => "600141",
            'ResponseType' => 'Completed',
            'ConfirmationURL' => "http://127.0.0.1:8000/api/v1/escrow/confirmation",
            'ValidationURL' => "http://127.0.0.1:8000/api/v1/escrow/validation"
        )));
        $curl_response = curl_exec($curl);
        echo $curl_response;
    }

    /**
     * Send confirmation SMS when user has paid
     */
    //public function sendConfirmationSMS( $phone_number, $message, $offerCode, $cpId, $linkId ){
        public function sendConfirmationSMS( $phone_number, $message ){
        
            $token = $this->GenerateToken();
            Log::info( $token );
            $phone = $this->parsePhoneNumber($phone_number);
            $message = $message;
            //$url12 = 'https://dsvc.safaricom.com:9480/api/auth/login';
            $url12 = 'https://dsvc.safaricom.com:9480/api/public/SDP/sendSMSRequest';
            $timeStamp =  date("YdmGis");
            $sms = 'API';
            $uniqueId = $phone.'_'.$timeStamp;
            $LinkId='';
            $OfferCode='001025328142';
            $CpId='253';
            $data='{
                            "requestId":"'.$uniqueId.'",					                    					                
                                                "requestTimeStamp": "'.date("YdmGis").'", 
                                                "channel": "'.$sms.'",   
                                                "sourceAddress": "104.131.111.145",									                                      
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
            Log::info("SendSMS-GetTokenResponse:".$results12);
                $objs12 = json_decode($results12,true);
                $token=$objs12['token'];
                //Log::info('token '.$token);
                $refreshToken = $objs12['refreshToken'];
    
    
            }
            catch(\Exception $e)
            {
                $token=$e->getMessage();
            }
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

}