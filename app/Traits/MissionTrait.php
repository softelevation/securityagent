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

trait MissionTrait
{
    /** 
    * Save Mission Details
    */
    public function saveQuickMissionDetails($data){
        $data['customer_id'] = \Auth::user()->customer_info->id;
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
    
}
