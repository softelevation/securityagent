<?php

namespace App\Helpers;

use Plivo\RestClient;

class PlivoSms
{
    
    const PLIVO_KEY = "MAYZMWZDIYYMU5OGRHNJ";
    const PLIVO_SECRET = "NzI1YWFhMjE1NjZhY2U4YTliYzJiZjFhNjY4ODkx";
    const PLIVO_PHONE = '+33685151627';
//    const pLivoClient = '';
    protected $pLivoClient;
    
    public static function getClient() {
        return new RestClient(self::PLIVO_KEY, self::PLIVO_SECRET);
    }
    /**
     * @param   : $validation
     * @rresponse
     * @purpose : Response while validation errors occurs
     */
    public static function sendSms($params){

            $plivoClient = self::getClient();
            $message_created = $plivoClient->messages->create(
                self::PLIVO_PHONE,
                [$params['phoneNumber']],
                    $params['msg']
            );
        
    }

}
