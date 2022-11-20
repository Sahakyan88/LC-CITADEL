<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Twilio\Rest\Client;

class Sms extends Model
{
    use HasFactory;
    protected $table = 'sms';

    public static function send($phone,$message){
        // $sid = ENV('TWILIO_SID');
        // $token = ENV('TWILIO_TOKEN');
        // $twilio_phone = ENV('TWILIO_PHONE_NUMBER');

        // $twilio = new Client($sid, $token);

        // $phone = "+".$phone;
        // $result = $twilio->messages ->create($phone,
        //                    array(
        //                     "from" => $twilio_phone, 
        //                     "body" => $message
        //                    ) 
        //         ); 
        // return $result;

        $username = ENV('SMS_LOGIN');
        $password = ENV('SMS_PASSWORD');
        $sender = 'iGorc';
        $host = 'http://45.131.124.7/broker-api/send';
        $messageId = date('YmdHi');
        $data = array('messages'=>array(
                                        'recipient'=>$phone,
                                        'priority'=>2,
                                        'message-id' => $messageId,
                                        'sms' => array(
                                            'originator'=>$sender,
                                            'content'=>array(
                                                'text'=>$message
                                            )
                                        )),
                    );
        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'charset: utf-8'));
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($ch);
        curl_close($ch);
        $status = substr($return, -2);
        if($status == "OK"){
            return true;
        }
        return false;
    }
}
