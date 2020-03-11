<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validators\OperatorValidator;
use App\Traits\ResponseTrait;
use App\Traits\HelperTrait;
use Auth;
use App\Agent;
use App\Operator;
use App\User;
use App\Customer;
use App\Mission;
use App\Helpers\Helper;
use Hash;
use DB;
use App\Notifications\MissionCreated;
use Carbon\Carbon;
use App\UserPaymentHistory;

class OperatorController extends Controller
{

	use OperatorValidator, ResponseTrait;

    public $limit;

    public function __construct(){
        $this->limit = 10;
    }
    
    /**
     * @return mixed
     * @method loadDashboardView
     * @purpose Load dashboard view
     */
    public function loadProfileView(){
        $profile = '';
        $profile = Operator::select('first_name','last_name','phone','image','home_address')->where('user_id',\Auth::id())->first();
        if($profile){
            $profile = $profile->toArray();
        }
        $data['profile'] = $profile;
    	return view('operator.profile',$data);
    }

    /**
     * @return mixed
     * @method viewAgentsList
     * @purpose View Agents List
     */
    public function viewAgentsList(Request $request){
        $pendingAgents = Agent::where('status',0)->orderBy('id','DESC')->paginate($this->limit,['*'],'pending');
        $verifiedAgents = Agent::where('status',1)->orderBy('id','DESC')->paginate($this->limit,['*'],'verified');
        $params = [
            'pending_agents' => $pendingAgents,
            'verified_agents' => $verifiedAgents,
            'page_no' => 1,
            'page_name' => 'pending',
            'limit' => $this->limit
        ];
        if($request->isMethod('get')){
            if(!empty($request->all())){
                $pageName = array_keys($request->all());
                $pageNo = array_values($request->all());
                $params['page_no'] = $pageNo[0]; 
                $params['page_name'] = $pageName[0];
            }
        }
        return view('operator.agents_list',$params);
    }

    /**
     * @return mixed
     * @method viewAgentDetails
     * @purpose View details of agents
     */
    public function viewAgentDetails($en_id){
        $id = Helper::decrypt($en_id);
        $agent = Agent::where('id',$id)->first();
        return view('operator.agent_details',['data'=>$agent]);
    }

    /**
     * @return mixed
     * @method agentVerificationAction
     * @purpose To process agent verification
     */
    public function agentVerificationAction(Request $request){
        $status = $request->verify_status;
        $user_id = Helper::decrypt($request->user_id);
        $result = Agent::where('user_id',$user_id)->update(['status'=>$status]);
        if($result){
            $password1 = Helper::generateToken(8);
            $password = Hash::make($password1);
            User::where('id',$user_id)->update(['password'=>$password]);
            $user = User::where('id',$user_id)->first();
            if($status==1){
                $message = "<b>Congratulations</b><br>Your agent verification is completed successfully and your details are approved.<br><br>Your login credentials are:<br><br>Email:".$user->email."<br> Password:".$password1;
            }else{
                $message = "Your agent verification is completed successfully and your details are rejected.<br><br>Thanks";
            }
            $templateName = 'emails.general';
            $data['message'] = $message;
            $toEmail = $user->email;
            $toName = $user->email;
            $subject = "Agent Verification";
            Helper::sendCommonMail($templateName,$data,$toEmail,$toName,$subject);
            $response['message'] = 'Agent verification completed successfully.';
            $response['delayTime'] = 2000;
            $response['url'] = url('operator/agents');
            return $this->getSuccessResponse($response);
        }else{
            return response($this->getErrorResponse('Something went wrong. Try again later !'));
        }
    }

    /**
     * @return mixed
     * @method viewCustomersList
     * @purpose Load customer list view
     */
    public function viewCustomersList(Request $request){
        $customers = Customer::orderBy('id','DESC')->paginate($this->limit);
        $params = [
            'data' => $customers,
            'limit' => $this->limit,
            'page_no' => 1
        ];
        if(isset($request->page)){
            $params['page_no'] = $request->page; 
        }
        return view('operator.customers_list',$params);
    }

    /**
     * @return mixed
     * @method viewCustomerDetails
     * @purpose View details of customer
     */
    public function viewCustomerDetails($en_id){
        $id = Helper::decrypt($en_id);
        $customer = Customer::where('id',$id)->first();
        return view('operator.customer_details',['data'=>$customer]);
    }

    /**
     * @return mixed
     * @method agentVerificationAction
     * @purpose To process agent verification
     */
    public function customerVerificationAction(Request $request){
        $status = $request->verify_status;
        $user_id = Helper::decrypt($request->user_id);
        $result = Customer::where('user_id',$user_id)->update(['status'=>$status]);
        if($result){
            $password1 = Helper::generateToken(8);
            $password = Hash::make($password1);
            User::where('id',$user_id)->update(['password'=>$password]);
            $user = User::where('id',$user_id)->first();
            if($status==1){
                $message = "<b>Congratulations</b><br>Your profile verification is completed successfully and your details are approved.<br><br>Your login credentials are:<br><br>Email: ".$user->email."<br> Password: ".$password1;
            }else{
                $message = "Your profile verification is completed successfully and your details are rejected.<br><br>Thanks";
            }
            $templateName = 'emails.general';
            $data['message'] = $message;
            $toEmail = $user->email;
            $toName = $user->email;
            $subject = "Customer Verification";
            Helper::sendCommonMail($templateName,$data,$toEmail,$toName,$subject);
            $response['message'] = 'Customer verification completed successfully.';
            $response['delayTime'] = 2000;
            $response['url'] = url('operator/customers/pending');
            return $this->getSuccessResponse($response);
        }else{
            return response($this->getErrorResponse('Something went wrong. Try again later !'));
        }
    }

    /**
     * @return mixed
     * @method missionsList
     * @purpose To get all missions list
     */
    public function missionsList(Request $request){
        $missionAll = Mission::with('child_missions')->where('parent_id',0)->orderBy('id','DESC')->paginate($this->limit,['*'],'all');
        $missionFuture = Mission::with('child_missions')->where('quick_book',0)->where('parent_id',0)->orderBy('id','DESC')->paginate($this->limit,['*'],'future');
        $missionQuick = Mission::where('quick_book',1)->orderBy('id','DESC')->paginate($this->limit,['*'],'quick');
        $missionCompleted = Mission::with('child_missions')->where('parent_id',0)->where('status',5)->orderBy('id','DESC')->paginate($this->limit,['*'],'finished');        
        $statusArr = Helper::getMissionStatus();
        $statusArr = array_flip($statusArr);
        $params = [
            'mission_all' => $missionAll,
            'future_mission' => $missionFuture,
            'quick_mission' => $missionQuick,
            'finished_mission' => $missionCompleted,
            'status_list'=>$statusArr,
            'limit' => $this->limit,
            'page_no' => 1,
            'page_name' => 'all'
        ];
        if($request->isMethod('get')){
            if(isset($request->all)){ 
                $params['page_no'] = $request->all; 
                $params['page_name'] = 'all'; 
            }
            if(isset($request->future)){ 
                $params['page_no'] = $request->future; 
                $params['page_name'] = 'future'; 
            }
            if(isset($request->quick)){ 
                $params['page_no'] = $request->quick; 
                $params['page_name'] = 'quick'; 
            }
            if(isset($request->finished)){ 
                $params['page_no'] = $request->finished; 
                $params['page_name'] = 'finished'; }
        }
        return view('operator.missions',$params);


        // $missions = Mission::orderBy('id','DESC')->paginate(10);
        // $data['missions'] = $missions;
        // return view('operator.missions',$data);
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
        return view('operator.view_mission_details',$data);
    }

    /**
     * @return mixed
     * @method verifyMission
     * @purpose To verify a mission
     */
    public function verifyMission(Request $request, $id){
        $id = Helper::decrypt($id);
        $mission = Mission::where('id',$id)->first();
        return view('operator.verify_mission',['data'=>$mission]);
    }

    /**
     * @param $mission_id
     * @return mixed
     * @method assignMissionAgent
     * @purpose Assign mission agent
     */
    public function assignMissionAgent($mission_id){
        $mission_id = Helper::decrypt($mission_id);
        $data['mission'] = $mission = Mission::where('id',$mission_id)->first();
        // Check if any agent available 
        $agent_type_needed = $mission->agent_type;
        // Get nearest agent
        $agents = Agent::whereHas('types',function($q) use($agent_type_needed){
            $q->where('agent_type',$agent_type_needed);
        })->whereHas('schedule')->where('status',1)->where('available',1)->select(DB::raw("*, 111.111 *
                DEGREES(ACOS(LEAST(1.0, COS(RADIANS(".$mission->latitude."))
                * COS(RADIANS(work_location_latitude))
                * COS(RADIANS(".$mission->longitude." - work_location_longitude))
                + SIN(RADIANS(".$mission->latitude."))
                * SIN(RADIANS(work_location_latitude))))) AS distance_in_km"))->having('distance_in_km', '<', 100)->orderBy('distance_in_km','ASC')->get(); 
        $data['agents'] = $agents;  
        return view('operator.assign_agent',$data);
    }

    public function bookAgentLaterMission(Request $request){
        try{
            $mission_id = Helper::decrypt($request->mission_id);
            $agent_id = Helper::decrypt($request->agent_id);
            Mission::where('id',$mission_id)->update(['agent_id'=>$agent_id]);
            $mission = Mission::where('id',$mission_id)->first();
            /*----Agent Notification-----*/
            if(isset($mission->agent_details)){
                $mailContent = [
                    'name' => ucfirst($mission->agent_details->first_name),
                    'message' => 'You have a new mission request. Click on the button below to view details and accept/reject mission, before it expires.', 
                    'url' => url('agent/mission-details/view').'/'.$request->mission_id 
                ];
                $mission->agent_details->user->notify(new MissionCreated($mailContent));
            }
            /*--------------*/
            $response['message'] = 'Mission request sent to agent.';
            $response['delayTime'] = 2000;
            $response['url'] = url('operator/missions');
            return $this->getSuccessResponse($response);
        }catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
    }

    public function createSubMissions($mission_id){
        $mission_id = Helper::decrypt($mission_id);
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
        $time = $mission->start_date_time;
        $x=0;
        foreach ($hours as $key => $value) {
            $x++;
            if($x!=1){
                $time = date("Y-m-d H:i:s", strtotime('+'.$value.' hours', strtotime($time)));
            }
            $data['start_date_time'] = $time;
            $data['total_hours'] = $value;
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();
            $data['parent_id'] = $mission->id;
            Mission::insert($data);
        }
        return redirect('operator/missions');
    }

    /**
     * @param $request
     * @return mixed
     * @method getPaymentHistory
     * @purpose Get payment history
     */
    public function getPaymentHistory(Request $request){
        $data = UserPaymentHistory::orderBy('id','DESC')->paginate($this->limit);
        $params = [
            'history' => $data,
            'limit' => $this->limit,
            'page_no' => 1
        ];
        if(isset($request->page)){
            $params['page_no'] = $request->page; 
        }
        return view('operator.billing',$params);
    }
    
}
