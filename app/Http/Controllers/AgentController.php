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

class AgentController extends Controller
{
	use AgentValidator, AgentTrait, ResponseTrait;
    
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
        return view('agent.profile');
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
        $schedule = AgentSchedule::where('id',$agent_id)->first();
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
        $isExists = AgentSchedule::where('agent_id',$agent_id)->first();
        if($isExists){
            $result = AgentSchedule::where('agent_id',$agent_id)->update($post);
        }else{
            $post['agent_id'] = $agent_id;
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


}
