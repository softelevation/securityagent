<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validators\OperatorValidator;
use App\Traits\ResponseTrait;
use App\Traits\HelperTrait;
use App\Traits\PaymentTrait;
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
use App\PaymentApproval;
use App\RefundRequest;


class OperatorController extends Controller
{

	use OperatorValidator, ResponseTrait, PaymentTrait;

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
        $missionQuick = Mission::with('child_missions')->where('quick_book',1)->where('parent_id',0)->orderBy('id','DESC')->paginate($this->limit,['*'],'quick');
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
            Mission::where('id',$mission_id)->update(['agent_id'=>$agent_id,'assigned_at'=>Carbon::now()]);
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
                $time = $new_time;
            }
            $data['start_date_time'] = $time;
            $data['total_hours'] = $value;
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();
            $data['parent_id'] = $mission->id;
            $new_time = date("Y-m-d H:i:s", strtotime('+'.$value.' hours', strtotime($time)));
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

    /**
     * @param $request
     * @return mixed
     * @method paymentApprovalsView
     * @purpose View list of payment approvals
     */
    public function paymentApprovalsView(Request $request){
        $data = PaymentApproval::where('status',0)->orderBy('id','DESC')->paginate($this->limit);
        $params = [
            'payments' => $data,
            'limit' => $this->limit,
            'page_no' => 1
        ];
        if(isset($request->page)){
            $params['page_no'] = $request->page; 
        }
        return view('operator.payment_approval',$params);
    }

    /**
     * @param $request
     * @return mixed
     * @method paymentApprovalAction
     * @purpose View list of payment approvals
     */
    public function paymentApprovalAction(Request $request){
        try{
            $record_id = Helper::decrypt($request->record_id);
            $type = $request->type;
            $data = PaymentApproval::where('id',$record_id)->first();
            if($type==1){
                $chargeData = [
                    'customer' => $data->customer_details->customer_stripe_id,
                    'currency' => config('services.stripe.currency'),
                    'amount'   => $data->amount,
                    'description' => 'Extra Mission Charge Amount',
                ];
                $charge = $this->createCharge($chargeData);
                $responseData = [
                    'customer_id'   => $data->customer_id,
                    'mission_id'    => $data->mission_id,
                    'amount'        => $data->amount,
                    'status'        => $charge['status'],
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ];
                if($charge['status']=='succeeded'){
                    // Save data to payment history
                    $responseData['charge_id'] = $charge['id'];
                    $result = UserPaymentHistory::insert($responseData);
                    if($result){
                        PaymentApproval::where('id',$record_id)->update(['status'=>1]);
                        $response['message'] = 'Mission payment done successfully.';
                        $response['delayTime'] = 2000;
                        $response['url'] = url('operator/payment-approvals');
                        return $this->getSuccessResponse($response);
                    }else{
                        $response['message'] = 'Something went wrong !';
                        $response['delayTime'] = 2000;
                        $response['url'] = url('operator/payment-approvals');
                        return $this->getErrorResponse($response);
                    }
                }else{
                    // Store Failed Payment 
                    $responseData = [ 
                        'remarks' => 'Extra Mission Amount', 
                        'response' => json_encode($charge),
                    ];
                    FailedPayment::insert($responseData);

                    $response['message'] = 'Mission payment failed !';
                    $response['delayTime'] = 2000;
                    $response['url'] = url('operator/payment-approvals');
                    return $this->getErrorResponse($response);
                }
            }else{
                PaymentApproval::where('id',$record_id)->update(['status'=>2]);
                $response['message'] = 'Mission payment reject successfully.';
                $response['delayTime'] = 2000;
                $response['url'] = url('operator/payment-approvals');
                return $this->getSuccessResponse($response);
            }

        }catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
    }

    /**
     * @return mixed
     * @method missionsListWithoutAgents
     * @purpose To get all missions list without agents
     */
    public function missionsListWithoutAgents(Request $request){
        $missions = Mission::where('status',0)->where('agent_id',0)->where('payment_status',1)->orderBy('id','DESC')->paginate($this->limit); 
        $statusArr = Helper::getMissionStatus();
        $params = [
            'data' => $missions,
            'status_list'=>$statusArr,
            'limit' => $this->limit,
            'page_no' => 1
        ];
        if(isset($request->page)){
            $params['page_no'] = $request->page; 
        }
        return view('operator.missions_without_agents',$params);
    }

    /**
     * @return mixed
     * @method refundRequestsView
     * @purpose Refund Requests
     */
    public function refundRequestsView(Request $request){
        $refunds = RefundRequest::orderBy('id','DESC')->paginate($this->limit); 
        $params = [
            'refunds' => $refunds,
            'limit' => $this->limit,
            'page_no' => 1
        ];
        if(isset($request->page)){
            $params['page_no'] = $request->page; 
        }
        return view('operator.refund_requests',$params);
    }

    /**
     * @return mixed
     * @method processRefundRequest
     * @purpose Process Refund Requests
     */
    public function processRefundRequest(Request $request){
        try{
            $record_id = Helper::decrypt($request->record_id);
            $refund_status = $request->refund_status;
            if($refund_status==1){
                $record = RefundRequest::where('id',$record_id)->first();
                $mission_id = $record->mission_id;
                $this->print($mission_id);
            }
            if($refund_status==2){
                $result = RefundRequest::where('id',$record_id)->update(['status'=>3]);
                if($result){
                    $response['message'] = 'Refund request rejected successfully.';
                    $response['delayTime'] = 2000;
                    $response['url'] = url('operator/refund-requests');
                    return $this->getSuccessResponse($response);
                }        
            }
        }catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
    }

    /**
     * @param $mission_id
     * @return mixed
     * @method viewMissionDetailsRefund
     * @purpose View refund mission details
     */
    public function viewMissionDetailsRefund($mission_id){
        $mission_id = Helper::decrypt($mission_id);
        $data['mission'] = Mission::where('id',$mission_id)->first();
        return view('operator.view_mission_details_refund',$data);
    }


    /**
     * @param $mission_id
     * @return mixed
     * @method refundMissionAmount
     * @purpose Refund mission amount
     */
    public function refundMissionAmount(Request $request){
        try {
            $mission_id = Helper::decrypt($request->mission_id);
            $charge_id = $request->charge_id;
            $response = $this->refundCharge($charge_id);
            if($response['status']=='succeeded'){
                RefundRequest::where('mission_id',$mission_id)->update(['status'=>1]);
                $result = UserPaymentHistory::where('charge_id',$charge_id)->where('mission_id',$mission_id)->update(['refund_status'=>$response['status']]);
                if($result){
                    $response['message'] = 'Amount refunded successfully.';
                    $response['delayTime'] = 2000;
                    $response['url'] = url('operator/refund-mission-view/'.Helper::encrypt($mission_id));
                    return $this->getSuccessResponse($response);
                }
            }
        } catch (\Exception $e) {
            return response($this->getErrorResponse($e->getMessage()));
        }
    }    
}
