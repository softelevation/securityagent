<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\HelperTrait;
use App\Traits\ResponseTrait;
use App\Traits\MissionTrait;
use App\Traits\CurlTrait;
use Illuminate\Support\Facades\Session;
use App\Notifications\AgentCreated;
use App\Helpers\Helper;
use App\Customer;
use App\User;
use DB;

trait CustomerTrait
{
    use HelperTrait, MissionTrait, CurlTrait;

    /**
    * Save customer data to database
    */

    public function registerCustomer($request){
    	try{
            // DB::beginTransaction();
            $post = array_except($request->all(),['_token','password_confirmation','captcha']);
			$result = $this->Make_Login('customer/signup',$post);
            if($result->status){
                $response['url'] = url('/');
				$response['message'] = trans('messages.user_registered');
				$response['delayTime'] = 5000;
				return $this->getSuccessResponse($response);
            }else{
				// return $this->getErrorResponse(trans('messages.error'));
				return $this->getErrorResponse($result->message);
            }
        }catch(\Exception $e){
            // DB::rollback();
            return $this->getErrorResponse($e->getMessage());
        }           
    }

    /**
    * Get available agents from database
    */
    public function getAvailableAgents($request){
        $a = Agent::where('status',1);
        if(isset($request->type) && $request->type=='is_vehicle'){
            $a->where('is_vehicle',$request->value);
        }
        if(isset($request->type) && $request->type=='agent_type'){
            $typeID = $request->value;
            $a->whereHas('types',function($q) use ($typeID){
                $q->where('agent_type',$typeID);
            });
        }
        $agents = $a->get();
        $agentArr = [];
        foreach($agents as $agent){
            $strArr   = [];
            $strArr['username'] = $agent->username;
            $strArr['avatar_icon'] = asset('avatars/'.$agent->avatar_icon);
            $strArr['image'] = $agent->image;
            $strArr['agent_type'] = $agent->agent_type;
            $strArr['lat'] = trim($agent->work_location_latitude);
            $strArr['long'] = trim($agent->work_location_longitude);
            $strArr['is_vehicle'] = $agent->is_vehicle;
            $strArr['types'] = $agent->types;
            $agentArr[] = $strArr; 
        }
        return $agentArr;
    }
}
