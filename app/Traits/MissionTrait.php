<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\ResponseTrait;
use App\Helpers\Helper;
use App\Agent;
use App\Customer;
use App\User;
use App\Mission;
use App\RefundRequest;
use App\MissionRequestsIgnored;
use App\Helpers\PlivoSms;
use Session;
use DB;
use Log;
use App\Notifications\MissionCreated;

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

        // If customer dont know, then set 8 hours default
        if($data['total_hours']==0){
            $data['total_hours'] = 8;
        }
        $baseRate = Helper::get_agent_rate($data['agent_type'],$data['quick_book']);
		if($data['intervention'] == 'Guard_service'){
			if($data['total_hours'] > 4){
				$data['amount'] = $data['total_hours']*$baseRate;
			}else{
				$data['amount'] = 4*$baseRate;
			}
		}else if($data['intervention'] == 'Intervention'){
			$data['amount'] = $data['total_hours'] * Helper::get_agent_rate(8,1);
		}else if($data['intervention'] == 'Security_patrol'){
			$data['amount'] = $data['total_hours'] * Helper::get_agent_rate(9,1);
		}else{
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
        $data['vat'] = $vat;
		
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
		$timeOutMin_limit = Helper::VAT_PERCENTAGE;
        // Check if mission has expired or not
        if($diffMinutes >= $timeOutMin){
            // Remove agent id from mission
            $result = Mission::where('id',$mission_id)->update(['agent_id'=>0,'assigned_at'=>Null]);
            if($result && $diffMinutes <= $timeOutMin_limit){
                // Set agent_id to ignored missions
                $ignoredMissionData = array(
                    'mission_id' => $mission_id,
                    'agent_id' => $mission->agent_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                );
                MissionRequestsIgnored::insert($ignoredMissionData);
                // Search for a new agent
                $agent = self::find_mission_agent($mission_id);
                // assign new agent if found
                if($agent){
                    $res = Mission::where('id',$mission_id)->update(['agent_id'=>$agent->id,'assigned_at'=>Carbon::now()]);
                    if($res){
                        $mission = Mission::where('id',$mission_id)->first();
                        /*----Agent Notification-----*/
                        $mailContent = [
                            'name' => ucfirst($mission->agent_details->first_name),
                            'message' => trans('messages.agent_new_mission_notification'), 
                            'url' => url('agent/mission-details/view').'/'.Helper::encrypt($mission_id)
                        ];
                        // $mail = $mission->agent_details->user->notify(new MissionCreated($mailContent));
                        /*--------------*/
                    }
                }
                $response = 1;
            }
        }
        return $response;
    }

    /** 
    * Find agent for a mission
    * @return boolean  
    */
    public function find_mission_agent($mission_id){
        $mission = Mission::where('id',$mission_id)->first();
        $agent_type_needed = $mission->agent_type;
        $a = Agent::whereHas('types',function($q) use($agent_type_needed){
                $q->where('agent_type',$agent_type_needed);
            })->whereDoesnthave('agent_ignored',function($w) use ($mission_id){
                $w->where('mission_id',$mission_id);
            });
        // Check if vehicle required or not
        if($mission->vehicle_required==1){
            $a->where('is_vehicle',1);
        }
        if($mission->vehicle_required==2){
            $a->where('is_vehicle',0);
        }
        $agent = $a->where('status',1)->where('available',1)->select(DB::raw("*, 111.111 *
                    DEGREES(ACOS(LEAST(1.0, COS(RADIANS(".$mission->latitude."))
                    * COS(RADIANS(work_location_latitude))
                    * COS(RADIANS(".$mission->longitude." - work_location_longitude))
                    + SIN(RADIANS(".$mission->latitude."))
                    * SIN(RADIANS(work_location_latitude))))) AS distance_in_km"))->having('distance_in_km', '<', 100)->orderBy('distance_in_km','ASC')->first();  
        return $agent;
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
            $now = Carbon::now();
            $update = Mission::where('id',$mission_id)->update(['status'=>$status,'ended_at'=>$now]);
            if($update){
                $mission = Mission::where('id',$mission_id)->first();
                Agent::where('id',$mission->agent_id)->update(['available'=>1]);
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
