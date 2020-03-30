<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AgentTrait;
use App\Validators\AgentValidator;
use App\Traits\ResponseTrait;
use Auth;
use App\Agent;
use App\AgentSchedule;
use App\Helpers\Helper;
use Session;
use App\Mission;
use Carbon\Carbon;
use App\Traits\MissionTrait;

class AgentController extends Controller
{
	use AgentValidator, AgentTrait, ResponseTrait, MissionTrait;
    
    /**
     * @param $request
     * @return mixed
     * @method index
     * @purpose Load agent signup view 
     */
    public function index(){
        return view('agent-register');
    }

    /**
     * @param $request
     * @return mixed
     * @method agentRegister
     * @purpose To register as an agent
     */
    public function signup(Request $request){
    	try{
            // Check Agent Table Validation
        	$validation = $this->agentSignupValidations($request);
            if($validation['status']==false){
                return response($this->getValidationsErrors($validation));
            }
            $agentType = json_decode($request->agent_type);
            if(empty($agentType)){
                return $this->getErrorResponse('Choose an agent type');
            }else{
                $cnaps = 0;
                foreach($agentType as $type){
                    if($type > 3){
                        $cnaps = 1;
                    }
                    if($type==6){
                        $dog = 1;
                    }
                }
                if($cnaps == 1){
                    if(empty(trim($request->cnaps_number))){
                        return $this->getErrorResponse('Please enter CNAPS Number');
                    }
                }
                if($dog == 1){
                    if(empty(trim($request->dog_info))){
                        return $this->getErrorResponse('Please enter dog mutual info');
                    }
                }
            }
            if(!isset($request->work_location['lat']) || empty($request->work_location['lat'])){
                return $this->getErrorResponse('GPS location is not enabled.');
            }
            // Works on HTTPS
            // if(!isset($request->current_location['lat']) || empty($request->current_location['lat'])){
            //     return $this->getErrorResponse('GPS location is not enabled.');
            // }
            return $this->registerAgent($request);
        }catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
    }

    /**
     * @param $request
     * @return mixed
     * @method showAvailableAgents
     * @purpose Show available agents on map
     */
    public function showAvailableAgents(Request $request){
        
        $latitude = '46.2276';
        $longitude = '2.2137';
        $location = 'France';
        $zoom = 6;
        $searchVal = false;
        if(isset($request->latitude) && isset($request->longitude)){
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $location = $request->location;
            $searchVal = true;
            $zoom = 8;
        }else{
            if(Session::has('mission')){
                Session::forget('mission');
            }
            $request->request->set('latitude',$latitude);
            $request->request->set('longitude',$longitude);
        }
        $search['latitude'] = $latitude;
        $search['longitude'] = $longitude;
        $search['location'] = $location;
        $search['s_val'] = $searchVal; 
        $search['zoom'] = $zoom;
        $agents = $this->getAvailableAgents($request);
        // $this->print($agents);
        return view('available_agents',['data'=>json_encode($agents),'search'=>$search]);
    }

    /**
     * @param $request
     * @return mixed
     * @method agentProfileView
     * @purpose Load agent profile view 
     */
    public function agentProfileView(){
        $profile = Agent::select('first_name','last_name','phone','image','home_address')->where('user_id',\Auth::id())->first()->toArray();
        $data['profile'] = $profile;
        return view('agent.profile',$data);
    }


    /**
     * @param $request
     * @return mixed
     * @method setAvailability
     * @purpose Set agent availability status
     */
    public function setAvailability(Request $request){
        try{
            if(Auth::check() && Auth::user()->role_id==2){
                $data = Agent::where('user_id',Auth::user()->id)->first();
                if($data->available==2){
                    return response($this->getErrorResponse("Availability status can't be changed during ongoing mission."));
                }else{
                    $availableStatus = $request->availability_status;
                    $update = Agent::where('user_id',Auth::user()->id)->update(['available'=>$availableStatus]);
                    if($update){
                        $response['message'] = 'Your availability status has been changed successfully.';
                        $response['delayTime'] = 5000;
                        $response['url'] = $request->current_url;
                        return response($this->getSuccessResponse($response));
                    }else{
                        return response($this->getErrorResponse('Something went wrong!'));
                    }
                }
            }else{
                return response($this->getErrorResponse('Unauthorized Access!'));    
            }
        }catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
    }

    /**
     * @param $request
     * @return mixed
     * @method viewAgentDetails
     * @purpose View agent details
     */
    public function viewAgentDetails($agent_id){
        $agent_id = Helper::decrypt($agent_id);
        $agent = Agent::where('id',$agent_id)->first();
        return view('view-agent-details',['agent'=>$agent]);
    }

    /**
     * @param $request
     * @return mixed
     * @method setScheduleView
     * @purpose Set Agent Schedule
     */
    public function setScheduleView($agent_id){
        $agent_id = Helper::decrypt($agent_id);
        $agent = Agent::where('id',$agent_id)->first();
        $schedule = AgentSchedule::select('schedule_date','available_from','available_to')->where('agent_id',$agent_id)->whereDate('schedule_date', '>=', Carbon::now())->get();
        return view('agent.schedule',['agent'=>$agent,'schedule'=>$schedule]);
    }

    /**
     * @param $request
     * @return mixed
     * @method saveSchedule
     * @purpose Save Schedule
     */
    public function saveSchedule(Request $request){
        $post = array_except($request->all(),'_token');
        $agent_id = Auth::user()->agent_info->id;
        $schedule_date = date('Y-m-d', strtotime($request->schedule_date));
        $post['schedule_date'] = $schedule_date;
        $isExists = AgentSchedule::where('agent_id',$agent_id)->whereDate('schedule_date',$schedule_date)->first();
        if($isExists){
            $result = AgentSchedule::where('agent_id',$agent_id)->update($post);
        }else{
            $post['agent_id'] = $agent_id;
            $post['created_at'] = Carbon::now();
            $post['updated_at'] = Carbon::now();
            $result = AgentSchedule::insert($post);
        }
        if($result){
            $response['message'] = 'Your schedule saved successfully.';
            $response['delayTime'] = 2000;
            $response['url'] = url('agent/schedule/'.Helper::encrypt($agent_id));
            return response($this->getSuccessResponse($response));
        }else{
            return response($this->getErrorResponse('Something went wrong!'));
        }
    }

    /**
     * @param $request
     * @return mixed
     * @method agentSubMissions
     * @purpose Agent Sub Missions
     */
    public function agentSubMissions(Request $request){
        try{
            $mission_id = Helper::decrypt($request->mission_id);
            $mission = Mission::where('id',$mission_id)->first();
            $total_hours = $mission->total_hours;
            $multiple = floor($total_hours/12);
            $remainder = $total_hours-$multiple*12;
            for($i=1; $i<=$multiple; $i++){
                $hours[] = 12;
            }
            if($remainder!=0){
                $hours[] = $remainder;
            }
            $data = $mission->toArray();
            $data = array_except($data,['id','created_at','updated_at','total_hours']);
            $time = Carbon::now();
            $x=0;
            $subMissions = [];
            foreach ($hours as $key => $value) {
                $x++;
                $data['status'] = 3;
                if($x!=1){
                    $data['agent_id'] = 0;
                    $data['status'] = 0;
                    $time = $new_time;
                }
                $data['start_date_time'] = $time;
                $data['total_hours'] = $value;
                $data['created_at'] = Carbon::now();
                $data['updated_at'] = Carbon::now();
                $data['parent_id'] = $mission->id;
                $new_time = date("Y-m-d H:i:s", strtotime('+'.$value.' hours', strtotime($time)));
                $subMissions[] = $data;
            }
            $result = Mission::insert($subMissions);
            if($result){
                Mission::where('id',$mission_id)->update(['agent_id'=>0]);
                $response['message'] = 'Mission request accepted successfully for 12 hours.';
                $response['delayTime'] = 2000;
                $response['modelhide'] = '#mission_action';
                $response['url'] = url('agent/mission-requests');
                return response($this->getSuccessResponse($response));
            }else{
                return response($this->getErrorResponse('Something went wrong!'));
            }
        }catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
    }

    /**
     * @param $request
     * @return mixed
     * @method missionExpiredRequest
     * @purpose Agent mission expired
     */
    public function missionExpiredRequest(Request $request){
        $mission_id = Helper::decrypt($request->record_id);
        // Check if mission request is expired or not
        $mission_expired = $this->missionExpired($mission_id);
        if($mission_expired==1){
            $response = $this->getErrorResponse('Your mission has expired !');
            $response['url'] = url('agent/mission-requests');
            return response($response);
        }
    }

}
