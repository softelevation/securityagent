<?php

namespace App\Helpers;

use Plivo\RestClient;

class PlivoSms
{
    
    const PLIVO_KEY = "MAMTG5ZWJLMME5NJFMYM";
    const PLIVO_SECRET = "MGE1NWQ2YjEyYmY2MGFkZWRhZTA1NTNiZGY1M2Ix";
    const PLIVO_PHONE = '+1 954-231-6797';
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
			$phone_Number = ltrim($params['phoneNumber']);
			
			if($phone_Number[0] != '+'){
				$phone_Number = '+33'.$params['phoneNumber'];
			}
			
			// print_r($phone_Number);
			// die;
            $plivoClient = self::getClient();
            $message_created = $plivoClient->messages->create(
                self::PLIVO_PHONE,
                [$phone_Number],
                    $params['msg']
            );
        return true;
    }

}
