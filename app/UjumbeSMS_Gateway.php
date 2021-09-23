<?php

/**
 * 
 */
class UjumbeSMS_Gateway
{

    public $api_key = "";
    public $email = "";

    function __construct($api_key, $email)
    {

        $this->api_key = $api_key;
        $this->email = $email;


    }

    function getSendSmsUrl()
    {

        return "https://ujumbesms.co.ke/api/messaging";
    }

    /**
     * phone numbers seperated by commas
     */
    function prepare($data)
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

        $sms_data = json_encode($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->getSendSmsUrl());
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
            'X-Authorization: ' . $this->api_key,
            'email: ' . $this->email
        ));


        $response = curl_exec($curl);

        if ($response === false) {
            $err = 'Curl error: ' . curl_error($curl);
            curl_close($curl);
            return $err;
        } else {
            curl_close($curl);

            return $response;
        }
    }

    /**
     * @param $numbers = phone numbers separated with commas
     * @param $message
     * @param $sender = The sender id assigned by ujumbeSMS eg DepthSMS
     */
    function send($numbers, $message, $sender)
    {

        $data = [
            "numbers" => $numbers,
            "message" => $message,
            "sender" => $sender
        ];
        $this->prepare($data);

    }
}
