<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mission;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Traits\MissionTrait;
use Log;

class CommonController extends Controller
{
    use MissionTrait;

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
}
