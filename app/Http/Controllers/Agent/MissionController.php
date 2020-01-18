<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Validators\MissionValidator;
use App\Traits\ResponseTrait;
use App\Traits\PaymentTrait;
use App\Mission;
use App\UserPaymentHistory;
use App\Customer;
use App\Agent;
use Carbon\Carbon;
use App\Helpers\Helper;

class MissionController extends Controller
{
    use MissionValidator, ResponseTrait, PaymentTrait;


    /**
     * @param $request
     * @return mixed
     * @method index
     * @purpose Get Customer Mission's List 
     */
    public function index(){
        $statusArr = Helper::getMissionStatus();
        $statusArr = array_flip($statusArr);
    	$missionPending = Mission::where('agent_id',\Auth::user()->agent_info->id)->where('status',3)->get();
        $missionInProgress = Mission::where('agent_id',\Auth::user()->agent_info->id)->where('status',4)->get();
        $missionCompleted = Mission::where('agent_id',\Auth::user()->agent_info->id)->where('status',5)->get();
        $data['pending_mission'] = $missionPending;
        $data['inprogress_mission'] = $missionInProgress;
        $data['finished_mission'] = $missionCompleted;
        $data['status_list'] = $statusArr;
        return view('agent.missions',$data);
    }

    /**
     * @param $mission_id
     * @return mixed
     * @method viewMissionDetails
     * @purpose View mission details
     */
    public function viewMissionDetails($mission_id){
        $mission_id = Helper::decrypt($mission_id);
        $data['mission'] = Mission::where('id',$mission_id)->first();
        return view('agent.view_mission_details',$data);
    }


    /**
     * @param $request
     * @return mixed
     * @method startMission
     * @purpose Start a mission
     */
    public function startMission(Request $request){
        try{
            $mission_id = Helper::decrypt($request->mission_id);
            $timeNow = Carbon::now();
            $result = Mission::where('id',$mission_id)->update(['started_at'=>$timeNow,'status'=>4]);
            if($result){
                $data = Mission::where('id',$mission_id)->first();
                Agent::where('id',$data->agent_id)->update(['available'=>2]);
                $response['message'] = 'Your Mission has started now.';
                $response['delayTime'] = 2000;
                $response['modelhide'] = '#mission_action';
                $response['url'] = url('agent/missions');
                return response($this->getSuccessResponse($response));
            }else{
                $response['message'] = 'Something went wrong. Unable to start the misison at the moment.';
                $response['delayTime'] = 2000;
                $response['url'] = url('agent/missions');
                $response['modelhide'] = '#mission_action';
                return response($this->getErrorResponse($response));
            }
        }catch(\Exception $e){
                return response($this->getErrorResponse($e->getMessage()));
        }
    }


    /**
     * @param $request
     * @return mixed
     * @method finishMission
     * @purpose finish a mission
     */
    public function finishMission(Request $request){
        try{
            $mission_id = Helper::decrypt($request->mission_id);
            $timeNow = Carbon::now();
            $result = Mission::where('id',$mission_id)->update(['ended_at'=>$timeNow,'status'=>5]);
            if($result){
                $data = Mission::where('id',$mission_id)->first();
                Agent::where('id',$data->agent_id)->update(['available'=>1]);
                $response['message'] = 'Your Mission has finished now.';
                $response['delayTime'] = 2000;
                $response['modelhide'] = '#mission_action';
                $response['url'] = url('agent/missions');
                return response($this->getSuccessResponse($response));
            }else{
                $response['message'] = 'Something went wrong. Unable to start the misison at the moment.';
                $response['delayTime'] = 2000;
                $response['url'] = url('agent/missions');
                $response['modelhide'] = '#mission_action';
                return response($this->getErrorResponse($response));
            }
        }catch(\Exception $e){
                return response($this->getErrorResponse($e->getMessage()));
        }
    }
}
