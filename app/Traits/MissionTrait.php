<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\ResponseTrait;
use App\Helpers\Helper;
use App\Agent;
use App\User;
use App\Mission;
use App\RefundRequest;

trait MissionTrait
{
    /** 
    * Save Mission Details
    */
    public function saveQuickMissionDetails($data){
        $data['customer_id'] = \Auth::user()->customer_info->id;
        $data['assigned_at'] = Carbon::now(); 
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        $data['step'] = 1;
        $data['amount'] = 120;
        // If customer dont know, then set 8 hours default
        if($data['total_hours']==0){
            $data['total_hours'] = 8;
        }
        $baseRate = Helper::BASE_AGENT_RATE;
        if($data['total_hours'] > 4){
            $data['amount'] = $data['total_hours']*$baseRate;
        }
        // If distance is greater than 50 KM, add travel fee per km
        if(isset($data['distance'])){
            $agentDistance = round($data['distance']);
            if($agentDistance > 50){
                $data['amount'] = $data['amount']+(0.5*$agentDistance);
            }
            unset($data['distance']);
        }
        // Calculate VAT
        $vat = Helper::VAT_PERCENTAGE;
        $vatAmount = ($data['amount']*$vat)/100;
        $data['amount'] = $data['amount']+$vatAmount;
        if(isset($data['record_id']) && $data['record_id']!=""){
            $missionID = Helper::decrypt($data['record_id']);
            unset($data['record_id']);
            Mission::where('id',$missionID)->update($data);
        }else{
            $missionID = Mission::insertGetId($data);
        }
        return $missionID;
    }

    /** 
    * Expire mission if request timed out
    * @return boolean  
    */
    public function missionExpired($mission_id){
        $response = 0;
        $mission = Mission::where('id',$mission_id)->first();
        $timeFrom = Carbon::parse($mission->assigned_at);
        $timeTo = Carbon::now();
        $diffMinutes = $timeFrom->diffInMinutes($timeTo);
        $timeOutMin = Helper::REQUEST_TIMEOUT_MINUTES;
        if($diffMinutes > $timeOutMin){
            // Remove agent id from mission
            $result = Mission::where('id',$mission_id)->update(['agent_id'=>0]);
            if($result){
                $response = 1;
            }
        }
        return $response;
    }

    /** 
    * Cancel Mission
    * @return boolean  
    */
    public function cancelMissionRequest($mission_id){
        $role = Auth::user()->role_id;
        switch ($role) {
            case 1:
                $status = 6;
                break;
            case 2:
                $status = 7;
                break;
            case 3:
                $status = 8;
                break;
            case 4:
                $status = 9;
                break;
            
            default:
                $status = 'INVALID';
                break;
        }
        $response = 0;
        if($status!='INVALID'){
            $update = Mission::where('id',$mission_id)->update(['status'=>$status]);
            if($update){
                RefundRequest::insert([
                    'mission_id' => $mission_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                $response = 1;
            }
        }
        return $response;
    }

    /** 
    * Delete Mission
    * @return boolean  
    */
    public function deleteMissionRequest($mission_id){
        $response = 0;
        $delete = Mission::where('id',$mission_id)->delete();
        if($delete){
            $response = 1;
        }
        return $response;
    }
    
}
