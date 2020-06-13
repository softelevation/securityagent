<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\HelperTrait;
use App\Traits\ResponseTrait;
use App\Traits\MissionTrait;
use Illuminate\Support\Facades\Session;
use App\Helpers\Helper;
use App\Customer;
use App\User;
use DB;

trait CustomerTrait
{
    use HelperTrait, MissionTrait;

    /**
    * Save customer data to database
    */

    public function registerCustomer($request){
    	try{
            DB::beginTransaction();
            $post = array_except($request->all(),['_token','password_confirmation','captcha']);
            $roleID = $this->get_user_role_id('customer');
            // Insert data to users table
            $userData = [
                'email' => $post['email'],
                'password' => Hash::make($post['password']),
                'role_id' => $roleID,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $userID = User::insertGetId($userData);
            if($userID){
                $credentials = array('email'=>$post['email'],'password'=>$post['password']);
                unset($post['email'],$post['password']);

                $post['phone'] = '+33'.$post['phone'];
                $post['user_id']    = $userID;
                $post['status']     = 1;
                $post['created_at'] = Carbon::now();
                $post['updated_at'] = Carbon::now();
                $result = Customer::insert($post);
                if($result){
                    DB::commit();
                    $response['url'] = url('/');
                    // Check if any mission session data is set
                    if(Session::has('mission')){
                        if(Auth::attempt($credentials)) {
                            $mission = Session::get('mission');
                            $mission_id = $this->saveQuickMissionDetails($mission);
                            if($mission_id){
                                Session::forget('mission');
                                $mission_id = Helper::encrypt($mission_id);
                                $response['url'] = url('customer/find-mission-agent/'.$mission_id);
                            }
                        }
                    }
                    $response['message'] = trans('messages.user_registered');
                    $response['delayTime'] = 5000;
                    return $this->getSuccessResponse($response); 
                }else{
                    DB::rollback();
                    return $this->getErrorResponse(trans('messages.error'));
                }
            }else{
                DB::rollback();
                return $this->getErrorResponse(trans('messages.error'));
            }
        }catch(\Exception $e){
            DB::rollback();
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
