<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Customer;
use App\Traits\HelperTrait;
use App\Traits\ResponseTrait;
use DB;

trait CustomerTrait
{
    use HelperTrait;

    /**
    * Save customer data to database
    */

    public function registerCustomer($request){
    	try{
            DB::beginTransaction();
            $post = array_except($request->all(),['_token','password_confirmation']);
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
                unset($post['email'],$post['password']);
                $post['user_id']    = $userID;
                $post['status']     = 1;
                $post['created_at'] = Carbon::now();
                $post['updated_at'] = Carbon::now();
                $result = Customer::insert($post);
                if($result){
                    DB::commit();
                   $response['message'] = 'User has been registered successfully.';
                    $response['delayTime'] = 5000;
                    $response['url'] = url('/');
                    return $this->getSuccessResponse($response); 
                }else{
                    DB::rollback();
                    return $this->getErrorResponse('Something went wrong. Please try again later !');
                }
            }else{
                DB::rollback();
                return $this->getErrorResponse('Something went wrong. Please try again later !');
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
            $latlong  = explode(",", $agent->work_location_lat_long);
            $strArr['lat'] = trim($latlong[0]);
            $strArr['long'] = trim($latlong[1]);
            $strArr['is_vehicle'] = $agent->is_vehicle;
            $strArr['types'] = $agent->types;
            $agentArr[] = $strArr; 
        }
        return $agentArr;
    }
}
