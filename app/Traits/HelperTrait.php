<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;
use Mail;
use Str;

trait HelperTrait
{
    /**
     * @param $param
     * @return string
     * @method encrypt
     */
    public function encrypt($param){
        $data = Crypt::encrypt($param);
        return $data;
    }

    /**
     * @param $param
     * @return string
     * @method decrypt
     */
    public function decrypt($param){
        $data = Crypt::decrypt($param);
        return $data;
    }

    /**
     * @param int $length
     * @return string
     * @method generateToken
     */
    public function generateToken($length = 100){
        return str_random($length);
    }

    /*
    * @method      : sendCommonMail
    * @purpose     : To send mail
    */
    public function sendCommonMail($templateName,$data,$fromEmail,$fromName,$subject){
        $response = Mail::send($templateName, ['data' => $data], function($message) use ($fromEmail,$fromName,$subject) {
            $message->from($fromEmail, $fromName);
            $message->to(config('mail.to.address'), config('mail.to.name'))->subject($subject);
        });
        return $response;
    }

    /*
     * @method       : create_slug
     * @created_date : 11-09-2019 (dd-mm-yyyy)
     * @purpose      : to create url slug from string
     */
    public static function create_slug($string){
        $string = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
        return Str::kebab($string);
    }
}
