<?php
namespace App\Helpers;

use Auth;
use Crypt;
use Edujugon\PushNotification\PushNotification;
use Mail;


class Helper {

    const BASE_AGENT_RATE = 30;

    /*
     * @method       :  encryptDataId
     * @created_date :  22-03-2019
     * @purpose      :  to encrypt the data
     */
    public static function encrypt($id = null) {
        if ($id) {
            return Crypt::encrypt($id);
        }
        return false;
    }

    /*
     * @method       : decryptDataId
     * @created_date : 22-03-2019
     * @purpose      : to decrypt the data
     */
    public static function decrypt($encrypted_string = null) {
        if ($encrypted_string) {
            return Crypt::decrypt($encrypted_string);
        }
        return false;
    }

    /* Start API Helper Function */

    /*
    * @method       :   commonResponse
    * @create_date  :   08-04-2019
    * @return       :   data as []
    */
    public static function commonResponse($message = '', $success = false, $error = true, $result = [], $status = 400){
        $responseArr = array(
            'message' => $message, 
            'success' => $success, 
            'error' => $error,
            'status' => $status,
            'data'  => $result
        );

        return $responseArr;
    }

    /*
    * @method       :   get_role_name
    * @create_date  :   20-12-2019
    * @return       :   Get role name
    */
    public static function get_role_name($param){
        $array = array('','Customer','Agent','Operator','Admin');
        return $array[$param];
    }

    /*
    * @method       :   get_role_id
    * @create_date  :   20-12-2019
    * @return       :   Get role name
    */
    public static function get_role_id($param){
        $array = [
            'customer'  => 1,
            'agent'     => 2,
            'operator'  => 3,
            'admin'     => 4
        ];
        return $array[$param];
    }

    
    /*
    * @method       :   get_agent_type_list
    * @create_date  :   20-12-2019
    * @return       :   Get agent type list
    */
    public static function get_agent_type_list(){
        $agentList = ['Select','Agent SSIAP 1','Agent SSIAP 2','Agent SSIAP 3','ADS With Vehicle or Not','Body Guard Without Weapon','Dog Handler','Hostesses'];
        return $agentList;
    }

    /*
    * @method       :   get_agent_type_name
    * @create_date  :   20-12-2019
    * @return       :   Get agent type name
    */
    public static function get_agent_type_name($param){
        $agentList = ['','Agent SSIAP 1','Agent SSIAP 2','Agent SSIAP 3','ADS With Vehicle or Not','Body Guard Without Weapon','Dog Handler','Hostesses'];
        return $agentList[$param];
    }

    public static function get_agent_type_name_multiple($param){
        $agentList = ['','Agent SSIAP 1','Agent SSIAP 2','Agent SSIAP 3','ADS With Vehicle or Not','Body Guard Without Weapon','Dog Handler','Hostesses'];
        $strArr = [];
        foreach($param as $p){
            $strArr[] = $agentList[$p->agent_type]; 
        }
        $string = implode(', ',$strArr);
        return $string;
    }

    /*
    * @method       :   get_customer_type_name
    * @create_date  :   20-12-2019
    * @return       :   Get customer type name
    */
    public static function get_customer_type_name($param){
        $customerList = ['','Individual','Company'];
        return $customerList[$param];
    }




    /*
    * @method      : sendPushNotification
    * @created_date: 30-08-2019
    * @purpose     : To send push notifications on ios and android
    */
    public static function sendPushNotification($userId,$title,$message){
        try{
            $user = UserTokens::whereUserId($userId)->first();
            $deviceType = strtolower($user->device_type);
            switch($deviceType){
                //To send notification on android
                case 'android':
                    $push = new PushNotification('fcm');
                    $push->setApiKey(config('pushnotification.firebase.apiKey'));
                    break;
                //To send notification on ios
                case 'ios':
                    $push = new PushNotification('apn');
                    break;
            }
            $push->setMessage([
                'aps' => [
                    'alert' => [
                        'title' => $title,
                        'body' => $message
                    ],
                    'sound' => 'default',
                    'badge' => 1
                ]
            ])->setDevicesToken($user->device_token);
            $push = $push->send();
            $response = $push->getFeedback();
            return $response;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /*
    * @method      : sendCommonMail
    * @purpose     : To send mail
    */
    public static function sendCommonMail($templateName,$data,$toEmail,$toName,$subject){
        $response = Mail::send($templateName, ['data' => $data], function($message) use ($toEmail,$toName,$subject) {
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->to($toEmail, $toName)->subject($subject);
        });

        return $response;
    }

    /**
     * @param int $length
     * @return string
     * @method generateToken
     */
    public static function generateToken($length = 100){
        return str_random($length);
    }

    /**
     * @param int $length
     * @return string
     * @method getMissionStatus
     */
    public static function getMissionStatus($param=null){
        $statusArr =  [
            'Unverified'            => 0,
            'Verified'              => 1,
            'Rejected'              => 2,
            'Active'                => 3,
            'In Progress'           => 4,
            'Completed'             => 5,
            'Cancelled By Customer' => 6,
            'Cancelled By Agent'    => 7
        ];
        if($param==null){
            return $statusArr;
        }
        if(is_numeric($param)){
           $statusArr = array_flip($statusArr);
           return $statusArr[$param]; 
        }else{
            return $statusArr[$param];
        }
    }


    /**
     * @param $started_at,$ended_at
     * @return string
     * @method get_mission_hours
     */
    public static function get_mission_hours($started_at,$ended_at){
        $datetime1 = new \DateTime($started_at);
        $datetime2 = new \DateTime($ended_at);
        $interval = $datetime1->diff($datetime2);
        $timeDuration = '';
        if($interval->h!=0){
            $hours = $interval->format('%h Hour ');
            if($interval->h > 1){
                $hours = $interval->format('%h Hours ');
            }
            $timeDuration .= $hours;
        }
        if($interval->i!=0){
            $minutes = $interval->format('%i Minute');
            if($interval->i > 1){
                $minutes = $interval->format('%i Minutes');
            }

            $timeDuration .= $minutes;
        }
        return $timeDuration;
    }



}

?>