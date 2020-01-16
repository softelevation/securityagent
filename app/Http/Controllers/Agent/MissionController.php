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
}
