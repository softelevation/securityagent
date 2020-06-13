<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mission;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Traits\MissionTrait;
use Log;
use Session;
use App\Traits\ResponseTrait;
use App\Validators\UserValidator;

class CommonController extends Controller
{
    use MissionTrait, ResponseTrait, UserValidator;

	/**
     * @param $request
     * @return mixed
     * @method missionExpiredRequest
     * @purpose check missions expired
     */
    public function missionExpiredCronJob(Request $request){
        try{
            $timeNow = date('Y-m-d H:i:s');
            $duration = Helper::REQUEST_TIMEOUT_MINUTES;
            $data = Mission::whereRaw("DATE_ADD(assigned_at, INTERVAL ".$duration." MINUTE) < '".$timeNow."'")->where('agent_id','!=',0)->where('status',0)->whereNotNull('assigned_at')->get();
            if($data->count() > 0){
                foreach($data as $mission){
                    $message = '';
                    $mission_expired = $this->missionExpired($mission->id);
                    if($mission_expired==1){
                        $message = 'Mission ID => '.$mission->id.' Message => Mission Expired.'; 
                    }else{
                        $message = 'Mission ID => '.$mission->id.' Message => Error occured while expiring mission.';
                    }
                    Log::info($message);
                }
            }else{
            	Log::info('No record found!');
            }
        }catch(\Exception $e){
            Log::info($e->getMessage());
        }
    }

    /**
     * @param $lang
     * @method changeLanguage
     * @purpose Change website language
     */
    public function changeLanguage($lang){
        if($lang=='en'){
            Session::put('locale','en');
        }
        if($lang=='fr'){
            Session::put('locale','fr');
        }
        Session::save();
        return redirect()->back();
    }

    /**
     * @param $lang
     * @method changeLanguage
     * @purpose Change website language
     */
    public function submitContactForm(Request $request){
        try{
            $validation = $this->contactFormValidations($request);
            if($validation['status']==false){
                return response($this->getValidationsErrors($validation));
            }
            $data = $request->all();
            $templateName = 'emails.contact';
            $toEmail = 'contact@ontimebe.com';
            $toName = 'Be On Time';
            $subject = $request->subject;
            Helper::sendCommonMail($templateName,$data,$toEmail,$toName,$subject);
            $response['message'] = trans('messages.feedback_submitted');
            $response['delayTime'] = 2000;
            $response['url'] = url('contact-us');
            return response($this->getSuccessResponse($response));
        }catch(\Exception $e){
            return response(trans('messages.error'));
        }
    }
	
	public function suportTicket(Request $request){
		try{
            $validation = $this->supportFormValidations($request);
            if($validation['status']==false){
                return response($this->getValidationsErrors($validation));
            }
            $data = $request->all();
            $templateName = 'emails.general';
            $toEmail = $request->email;
            $toName = 'Be On Time';
            $subject = $request->subject;
            Helper::sendCommonMail($templateName,array('message'=>$data['feedback']),$toEmail,$toName,$subject);
            $response['message'] = trans('messages.feedback_submitted');
            $response['delayTime'] = 2000;
            $response['url'] = url('suport-ticket');
            return response($this->getSuccessResponse($response));
        }catch(\Exception $e){
            return response(trans('messages.error'));
        }		
	}

    public function refreshCaptcha(){
        return captcha_img();
    }
}
