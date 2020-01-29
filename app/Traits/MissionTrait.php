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
        if($data['total_hours'] > 4){
            $baseRate = Helper::BASE_AGENT_RATE;
            $data['amount'] = $data['total_hours']*$baseRate;
        }
        $missionID = Mission::insertGetId($data);
        return $missionID;
    }
    
}
