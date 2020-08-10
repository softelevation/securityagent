<?php
namespace App\Helpers;

use Auth;
use Crypt;
use Edujugon\PushNotification\PushNotification;
use Mail;
use App\Mission;
use App\Agent;
use App\CustomerNotification;
use App\PaymentApproval;
use App\RefundRequest;
use Carbon\Carbon;
use DB;
use App;

class Helper {

    const BASE_AGENT_RATE = 30;
    const MISSION_ADVANCE_PERCENTAGE = 30;
    const VAT_PERCENTAGE = 20;
    const REQUEST_TIMEOUT_MINUTES = 05;


    /*
     * @method       : get_agent_rate
     * @purpose      : get agent rate based on agent type and mission type
     */
    public static function get_agent_rate($agentType,$quickBooking){
        // Set rates for future missions
        if($quickBooking==0){
            $rate[1] = 25; //Agent SSIAP 1
            $rate[2] = 28; //Agent SSIAP 2
            $rate[3] = 75; //Agent SSIAP 3
            $rate[4] = 25; //ADS
            $rate[5] = 100; //Body Guard Without Weapon
            $rate[6] = 28; //Dog Handler
            $rate[7] = 25; //Hostesses
            $rate[8] = 60; //Intervention
            $rate[9] = 80; //security patrol
        }
        // Set rates for future missions
        if($quickBooking==1){
            $rate[1] = 35; //Agent SSIAP 1
            $rate[2] = 37; //Agent SSIAP 2
            $rate[3] = 75; //Agent SSIAP 3
            $rate[4] = 35; //ADS
            $rate[5] = 120; //Body Guard Without Weapon
            $rate[6] = 37; //Dog Handler
            $rate[7] = 35; //Hostesses
            $rate[8] = 60; //Intervention
            $rate[9] = 80; //security patrol
        }
        return $rate[$agentType];
    }

    /*
     * @method       :  encryptDataId
     * @created_date :  22-03-2019
     * @purpose      :  to encrypt the data
     */
    public static function encrypt($id = null) {
      //  dd($id);
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
        if(App::getLocale()=='fr'){
            $agentList = [
                __('frontend.select'),
                'Agent SSIAP 1',
                'Agent SSIAP 2',
                'Agent SSIAP 3',
                'ADS',
                'Garde du corps sans arme',
                'Maitre-chien',
                'Hôtesses d’accueil'
            ];
        }else{
            $agentList = [
                __('frontend.select'),
                'Agent SSIAP 1',
                'Agent SSIAP 2',
                'Agent SSIAP 3',
                'ADS',
                'Body Guard Without Weapon',
                'Dog Handler',
                'Hostesses'
            ];

        }
        return $agentList;
    }

    /*
    * @method       :   get_agent_type_name
    * @create_date  :   20-12-2019
    * @return       :   Get agent type name
    */
    public static function get_agent_type_name($param){
        if(App::getLocale()=='fr'){
            $agentList = [
                '',
                'Agent SSIAP 1',
                'Agent SSIAP 2',
                'Agent SSIAP 3',
                'ADS',
                'Garde du corps sans arme',
                'Maitre-chien',
                'Hôtesses d’accueil'
            ];
        }else{
            $agentList = [
                '',
                'Agent SSIAP 1',
                'Agent SSIAP 2',
                'Agent SSIAP 3',
                'ADS',
                'Body Guard Without Weapon',
                'Dog Handler',
                'Hostesses'
            ];

        }
        return $agentList[$param];
    }

    public static function get_agent_type_name_multiple($param){
        if(App::getLocale()=='fr'){
            $agentList = [
                '',
                'Agent SSIAP 1',
                'Agent SSIAP 2',
                'Agent SSIAP 3',
                'ADS',
                'Garde du corps sans arme',
                'Maitre-chien',
                'Hôtesses d’accueil'
            ];
        }else{
            $agentList = [
                '',
                'Agent SSIAP 1',
                'Agent SSIAP 2',
                'Agent SSIAP 3',
                'ADS',
                'Body Guard Without Weapon',
                'Dog Handler',
                'Hostesses'
            ];

        }
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
            'Cancelled By Agent'    => 7,
            'Cancelled By Operator' => 8,
            'Cancelled By Admin' => 9
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
        if($interval->d!=0){
            $days = $interval->format('%d Day ');
            if($interval->d > 1){
                $days = $interval->format('%d Days ');
            }
            $timeDuration .= $days;
        }
        if($interval->h!=0){
            $hours = $interval->format('%h Hour ');
            if($interval->h > 1){
                $hours = $interval->format('%h Hours ');
            }
            $timeDuration .= $hours;
        }
        if($interval->i!=0){
            $minutes = $interval->format('%i Minute ');
            if($interval->i > 1){
                $minutes = $interval->format('%i Minutes ');
            }
            $timeDuration .= $minutes;
        }
        if($interval->s!=0){
            $seconds = $interval->format('%s Second');
            if($interval->s > 1){
                $seconds = $interval->format('%s Seconds');
            }
            $timeDuration .= $seconds;
        }
        return $timeDuration;
    }

    /**
     * @return integer
     * @method get_misison_request_count
     */
    public static function get_misison_request_count(){
        $count = 0;
        if(Auth::check() && Auth::user()->role_id==2){
            $agent_id = Auth::user()->agent_info->id;
            $count = Mission::where('agent_id',$agent_id)
                            ->where('status',0)
							->where(function ($query) {
								$query->where('payment_status',1)
									  ->orWhere('payment_status',2);
							})
                            // ->where('payment_status',1)
                            ->count();
        }
        return $count;
    }

    /**
     * @return array
     * @method week_days
     */
    public static function week_days(){
        $days[1] = 'Sunday';
        $days[2] = 'Monday';
        $days[3] = 'Tuesday';
        $days[4] = 'Wednesday';
        $days[5] = 'Thursday';
        $days[6] = 'Friday';
        $days[7] = 'Saturday';
        return $days;
    }

    /**
     * @return integer
     * @method get_customer_notification_count
     */
	 
	 public static function get_operator_notification($input){
		$data = null;
		if(Auth::check() && Auth::user()->role_id==3){
		if($input == 'count'){
					$data = Agent::where('status',0)->count();
			}else if($input == 'data'){
				$data = Agent::where('status',0)->get();
			}
		}
        return $data;
    }
	
	public static function operator_request_message($id = null,$lang) {
		$data = $id;
		if ($lang == 'en') {
			$data = $id.' request is pending';
        }else{
			$data = 'La demande '.$id.' est en attente';
		}
        return $data;
    }
	
    public static function get_customer_notification_count(){
        $count = 0;
        if(Auth::check() && Auth::user()->role_id==1){
            $customer_id = Auth::user()->customer_info->id;
            $count = CustomerNotification::where('customer_id',$customer_id)
                            ->where('status',0)
                            ->count();
        }
        return $count;
    }

    /**
     * @return integer
     * @method get_customer_notification_count
     */
    public static function get_customer_notifications(){
        $data = null;
        if(Auth::check() && Auth::user()->role_id==1){
            $customer_id = Auth::user()->customer_info->id;
            $data = CustomerNotification::where('customer_id',$customer_id)->where('status',0)->get();
        }
        return $data;
    }


    /**
     * @return integer
     * @method get_customer_notification_count
     */
    public static function date_format_show($format='Y-m-d', $dateString=null){
        $date = date('Y-m-d');
        if($date!=null){
            $date = $dateString;
        }
        return date($format,strtotime($date));
    }

    /**
     * @return datetime
     * @method get_timeout_datetime
     */
    public static function get_timeout_datetime($datetime){
        $timeoutDuration = '+'.self::REQUEST_TIMEOUT_MINUTES.' minutes';
        return  date('F d, Y H:i:s',strtotime($timeoutDuration,strtotime($datetime)));
    }

    /**
     * @return string
     * @method mission_id_str
     */
    public static function mission_id_str($id){
        return 'MISN00'.$id;
    }

    /**
     * @return string
     * @method get_mission_status
     */
    public static function get_mission_status($status){
        if(App::getLocale()=='fr'){
            if($status==0){ $response = 'Non vérifié'; }
            if($status==1){ $response = 'Vérifié'; }
            if($status==2){ $response = 'Rejeté'; }
            if($status==3){ $response = 'Actif'; }
            if($status==4){ $response = 'En cours'; }
            if($status==5){ $response = 'Terminé'; }
            if($status==6){ $response = 'Annulé'; }
            if($status==7){ $response = 'Annulé'; }
            if($status==8){ $response = 'Annulé'; }
            if($status==9){ $response = 'Annulé'; }
            if($status==10){ $response = 'Archived'; }
        }else{
            if($status==0){ $response = 'Unverified'; }
            if($status==1){ $response = 'Verified'; }
            if($status==2){ $response = 'Rejected'; }
            if($status==3){ $response = 'Active'; }
            if($status==4){ $response = 'In Progress'; }
            if($status==5){ $response = 'Completed'; }
            if($status==6){ $response = 'Cancelled'; }
            if($status==7){ $response = 'Cancelled'; }
            if($status==8){ $response = 'Cancelled'; }
            if($status==9){ $response = 'Cancelled'; }
            if($status==10){ $response = 'Archived'; }
        }
        return $response;
    }

    /**
     * @return string
     * @method get_request_status
     */
    public static function get_refund_status($status){
        if(App::getLocale()=='fr'){
            if($status==0) { $response = 'En attente'; }
            if($status==1) { $response = 'Succès'; }
            if($status==2) { $response = 'Échoué'; }
            if($status==3) { $response = 'Rejeté'; }
        }else{
            if($status==0) { $response = 'Pending'; }
            if($status==1) { $response = 'Success'; }
            if($status==2) { $response = 'Failed'; }
            if($status==3) { $response = 'Rejected'; }
        }
        return $response;
    }


    /**
     * @return integer
     * @method get_refund_request_count
     */
    public static function get_refund_request_count(){
        return RefundRequest::where('status',0)->count();
    }

    /**
     * @return integer
     * @method get_payment_approval_count
     */
    public static function get_payment_approval_count(){
        return PaymentApproval::where('status',0)->count();
    }

    /**
     * @return integer
     * @method get_mission_without_agent_count
     */
    public static function get_mission_without_agent_count(){
        return Mission::where('status',0)->where('agent_id',0)->where(function ($query) {
								$query->where('payment_status',1)
									  ->orWhere('payment_status',2);
							})->count();
		// ->where('payment_status',1)
    }

    /**
     * @return integer
     * @method get_vat_amount
     */
    public static function get_vat_amount($final_amount,$vat){
        $x = $final_amount*$vat;
        $vat_amount = $x/(100+$vat);
        return $vat_amount;
    }

    /**
     * @return string
     * @method vehicle_required_status
     */
    public static function vehicle_required_status($vehicle_required){
        if(App::getLocale()=='fr'){
            if($vehicle_required==1){ return 'Oui'; }
            if($vehicle_required==2){ return 'Non'; }
            if($vehicle_required==3){ return "peu importe"; }
        }else{
            if($vehicle_required==1){ return 'Yes'; }
            if($vehicle_required==2){ return 'No'; }
            if($vehicle_required==3){ return "Doesn't Matter"; }
        }
    }

    /**
     * @return string
     * @method check_mission_assigning_delay
     * @purpose check is mission is not yet assigned to any agent from more than 30 minutes
     */
    public static function check_mission_assigning_delay($created_at){
        $timeFrom = Carbon::parse($created_at);
        $timeTo = Carbon::now();
        $diffMinutes = $timeFrom->diffInMinutes($timeTo);
        if($diffMinutes > 30){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @return string
     * @method check_mission_starting_delay
     * @purpose check is mission is not started after accepting from more than 60 minutes
     */
    public static function check_mission_starting_delay($assigned_at){
        $timeFrom = Carbon::parse($assigned_at);
        $timeTo = Carbon::now();
        $diffMinutes = $timeFrom->diffInMinutes($timeTo);
        if($diffMinutes > 60){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @return string
     * @method get_total_worked_hours
     * @purpose get total worked hours duration of agent
     */
    public static function get_total_worked_hours($agent_id){
        $data = Mission::selectRaw('SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(ended_at,started_at)))) as total_hours')->where('status',5)->where('agent_id',$agent_id)->first();
        return $data->total_hours;
    }

    /**
     * @return string
     * @method get_total_worked_hours
     * @purpose get total worked hours duration of agent
     */
    public static function get_total_missin_completed($agent_id){
        return Mission::where('status',5)->where('agent_id',$agent_id)->count();
    }
    
    /**
     * @return array
     * @method get_mission_status_array
     * @purpose get array of mission status
     */
    public static function get_mission_status_array(){
        $statusArray = [];
        if(App::getLocale()=='fr'){
            $statusArray = ['Non vérifié', 'Vérifié', 'Rejeté', 'Actif', 'En cours', 'Terminé', 'Annulé par le client', 'Annulé par l\'agent', 'Annulé par l\'opérateur', 'Annulé par l\'administrateur'];
        }else{
            $statusArray = ['Unverified', 'Verified', 'Rejected', 'Active', 'In Progress', 'Completed', 'Cancelled By Customer', 'Cancelled By Agent', 'Cancelled By Operator', 'Cancelled By Admin'];
        }
        return $statusArray;
    }
	
	public static function project_text($key){
		$name = '';
		$project = DB::table('projects')->select('name')->where('status','1')->where('key',$key)->first();
		if($project){
			$name = $project->name;
		}else{
			$name = '';
		}
		return $name;
	}

}

?>