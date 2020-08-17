<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Validators\MissionValidator;
use App\Traits\ResponseTrait;
use App\Traits\PaymentTrait;
use App\Mission;
use App\UserPaymentHistory;
use App\FailedPayment;
use App\Customer;
use App\MessageCenter;
use App\Agent;
use App\RejectedMission;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\CustomerNotification;
use App\Notifications\MissionCreated;
use App\Notifications\PaymentDone;
use App\PaymentApproval;
use App\Traits\MissionTrait;
use App\MissionRequestsIgnored;
use Session;
use App\Helpers\PlivoSms;
use Auth;

class MissionController extends Controller
{
    use MissionValidator, ResponseTrait, PaymentTrait, MissionTrait;

    private $limit; 

    public function __construct(){
        $this->limit = 10;
    }


    /**
     * @param $request
     * @return mixed
     * @method index
     * @purpose Get Customer Mission's List 
     */
    public function index(){
        $statusArr = Helper::getMissionStatus();
        $statusArr = array_flip($statusArr);
    	$missionPending = Mission::where('agent_id',\Auth::user()->agent_info->id)->where('status',3)->orderBy('id','DESC')->get();
        $missionInProgress = Mission::where('agent_id',\Auth::user()->agent_info->id)->where('status',4)->orderBy('id','DESC')->get();
        $missionCompleted = Mission::where('agent_id',\Auth::user()->agent_info->id)->where('status',5)->orderBy('id','DESC')->get();
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
     * @method viewMissionRequests
     * @purpose View Mission Request's List 
     */
    public function viewMissionRequests(Request $request){
        $awaitingRequests = Mission::where('agent_id',\Auth::user()->agent_info->id)->where('status',0)
							// ->where('payment_status',1)
							->where(function ($query) {
								$query->where('payment_status',1)
									  ->orWhere('payment_status',2);
							})->orderBy('id','desc')->paginate($this->limit,['*'],'awaiting');
        $expiredRequests = MissionRequestsIgnored::where('agent_id',\Auth::user()->agent_info->id)->where('is_deleted',0)->orderBy('id','DESC')->paginate($this->limit,['*'],'expired');
        $params = [
            'awaiting_requests' => $awaitingRequests,
            'expired_requests' => $expiredRequests,
            'page_no' => 1,
            'page_name' => 'awaiting',
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
        return view('agent.mission_requests',$params);
    }
	
	public function messageCenter(Request $request){
		$user_messages = MessageCenter::select('operators.user_id','operators.first_name','operators.last_name','message_centers.message','message_centers.message_type')->join('operators','operators.user_id','message_centers.operator_id')->where('message_centers.user_id',Auth::id())->orderBy('message_centers.created_at','ASC')->get();
		$customer_profile = Agent::select('first_name','last_name')->where('user_id',\Auth::id())->first();
		$params = array();
		$params['user_id'] =Auth::id();
		$params['cus_id'] = '1';
		$params['profile'] = '';
		$params['user_messages'] = $user_messages;
		$params['cus_profile'] = $customer_profile;
        return view('agent.message_center',$params);
    }
	
	public function messageCenterPost(Request $request){
		$inputData = $request->all();
		$updateData = array('user_id'=>$request->user_id,'operator_id'=>$request->cus_id,
							'message'=>$request->send_message,'message_type'=>'send_by_agent','status'=>'1',
							'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()
						);
		MessageCenter::insert($updateData);
		$profile = Agent::select('first_name','last_name')->where('user_id',\Auth::id())->first();
		$name_op = ($profile) ? $profile->first_name.' '.$profile->last_name : 'Unknown';
		return response()->json(array('status'=>1,'message_type'=>'send_by_agent','message'=>$name_op));
    }

    /**
     * @param $request
     * @return mixed
     * @method processMissionRequest
     * @purpose Process Mission Request
     */
    public function processMissionRequest(Request $request){
        try{
            $action = $request->action_value;

            $mission_id = Helper::decrypt($request->mission_id);
            $mission = Mission::with('customer_details')->where('id',$mission_id)->first();
            $customerNumber = $mission->customer_details->phone;
            
            // Check if mission request is expired or not
            $mission_expired = $this->missionExpired($mission_id);
            if($mission_expired==1){
                $response = $this->getErrorResponse(trans('messages.mission_expired'));
                $response['url'] = url('agent/mission-requests');
                return response($response);
            }
            if($action==1){
                $count = Mission::where('parent_id',$mission->parent_id)->where('status', '>', 0)->count();
                if($count==0){
                    Mission::where('id',$mission->parent_id)->update(['status'=>3]);
                }
                $result = Mission::where('id',$mission_id)->update(['status'=>3]);
                if($result){
                    $sessionName = 'mis_'.$mission_id.'_ignored';
                    if(Session::has($sessionName)){
                        Session::forget($sessionName);
                        Session::save();
                    }                    
                    
                    /*----Customer send phone notification-----*/
                    PlivoSms::sendSms(['phoneNumber' => $customerNumber, 'msg' => trans('messages.agent_mission_accept_plivo_message', ['missionId'=> $mission_id]) ]);
                    /*--------------*/
                    
                    $response['message'] = trans('messages.mission_accepted');
                    $response['delayTime'] = 2000;
                    $response['modelhide'] = '#mission_action';
                    $response['url'] = url('agent/mission-requests');
                    return response($this->getSuccessResponse($response));
                }else{
                    return response($this->getErrorResponse(trans('messages.error')));
                }
            }
            if($action==2){
                $data = [
                    'mission_id' => $mission_id,
                    'agent_id' => \Auth::user()->agent_info->id,
                    'reason' => $request->reason
                ];
                $result = RejectedMission::insert($data);
                if($result){
                    $result = Mission::where('id',$mission_id)->update(['agent_id'=>0]);
                    if($result){
                        $response['message'] = trans('messages.mission_rejected');
                        $response['delayTime'] = 2000;
                        $response['modelhide'] = '#mission_action';
                        $response['url'] = url('agent/mission-requests');
                        return response($this->getSuccessResponse($response));
                    }else{
                        return response($this->getErrorResponse(trans('messages.error')));    
                    }
                }else{
                    return response($this->getErrorResponse(trans('messages.error')));
                }
            }
        }catch(\Plivo\Exceptions\PlivoResponseException $e){
                $response['message'] = trans('messages.mission_accepted');
                $response['delayTime'] = 2000;
                $response['modelhide'] = '#mission_action';
                $response['url'] = url('agent/mission-requests');
                return response($this->getSuccessResponse($response));
        }catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
        
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
            $data = Mission::where('id',$mission_id)->first();
            // Check if mission cant be started before start time
            if(isset($data->start_date_time) && $data->start_date_time!=""){
                $start_time = Carbon::parse($data->start_date_time);
                $diff_in_minutes = $start_time->diffInMinutes($timeNow,false);
                if(!($diff_in_minutes >= 0)){
                    return response($this->getErrorResponse(trans('messages.start_before_time_error')));
                }else{
                    // Check if mission cant be started while any other mission is in progress
                    $activeCount = Mission::where('parent_id',$data->parent_id)->where('status',4)->count();
                    if($activeCount > 0){
                        return response($this->getErrorResponse(trans('messages.start_error_in_progress')));
                    }
                }
            }
            $count = Mission::where('parent_id',$data->parent_id)->where('status', 4)->count();
            if($count==0){
                Mission::where('id',$data->parent_id)->update(['status'=>4]);
            }
            $result = Mission::where('id',$mission_id)->update(['started_at'=>$timeNow,'status'=>4]);
			PlivoSms::sendSms(['phoneNumber' => $data->customer_details->phone, 'msg' => trans('messages.agent_mission_start', ['missionId'=> $mission_id]) ]);
            if($result){
                Agent::where('id',$data->agent_id)->update(['available'=>2]);
                $notification = array(
                    'customer_id' => $data->customer_id,
                    'mission_id' => $mission_id,
                    'content' => 'messages.mission_started',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()  
                );
                CustomerNotification::insert($notification);
                /*----Customer Notification-----*/
                $mailContent = [
                    'name' => ucfirst($data->customer_details->first_name),
                    'message' => trans('messages.mission_started_at').$timeNow.'.', 
                    'url' => url('customer/mission-details/view').'/'.$request->mission_id 
                ];
                $data->customer_details->user->notify(new MissionCreated($mailContent));
                /*------------*/
                $response['message'] = trans('messages.mission_started');
                $response['delayTime'] = 2000;
                $response['modelhide'] = '#mission_action';
                $response['url'] = url('agent/missions');
                return response($this->getSuccessResponse($response));
            }else{
                $response['message'] = trans('messages.error');
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
        $mission_id = Helper::decrypt($request->mission_id);
        $data = Mission::where('id',$mission_id)->first();
        $timeNow = Carbon::now();
        // check if extra hours spent on mission
        $missionStartTime = Carbon::create($data->started_at);
        $missionEndTime = $timeNow;
        $totalMissionMinutes = $missionStartTime->diffInMinutes($missionEndTime);
        $bookedMinutes = $data->total_hours*60;
        // Set default to 240 minutes(4 Hr) if total_hours is less than 4 
        if($data->total_hours < 4){
            $bookedMinutes = 240;
        }
        // Charge remaining amount in case of future missions
        if($data->quick_book==0){
            // if mission is parent mission and dont have any sub missions
            if($data->parent_id==0){
                $missionBalanceAmount = ($data->amount*70)/100;
                // Make Charge Payment
                $customer_stripe_id = $data->customer_details->customer_stripe_id;
                $chargeData = [
                    'customer' => $customer_stripe_id,
                    'currency' => config('services.stripe.currency'),
                    'amount'   => $missionBalanceAmount,
                    'description' => 'Mission Remaining Charge Amount',
                ];
                try{
                    $charge = $this->createCharge($chargeData);
                    if($charge['status']=='succeeded'){
                        // Save data to payment history
                        $paymentDetails = [
                            'amount'      => $missionBalanceAmount,
                            'status'      => $charge['status'],  
                            'charge_id'   => $charge['id'],
                            'mission_id'  => $mission_id,
                            'customer_id' => $data->customer_details->id,
                            'created_at'  => Carbon::now(),
                            'updated_at'  => Carbon::now() 
                        ];
                        UserPaymentHistory::insert($paymentDetails);
                        /*----Payment Notification-----*/
                        $mailContent = [
                            'name' => ucfirst($data->customer_details->first_name),
                            'message' => trans('messages.payment_done_message',['amount'=>$missionBalanceAmount]), 
                            'url' => url('customer/billing-details') 
                        ];
                        $data->customer_details->user->notify(new PaymentDone($mailContent));
                        /*--------------*/ 
                    }
                }catch(\Exception $e){
                    // Store Failed Payment 
                    $failedData = [
                        'customer_id'   => $data->customer_details->id, 
                        'mission_id'    => $mission_id, 
                        'amount'        => $missionBalanceAmount, 
                        'remarks'       => 'Mission Remaining Charge Amount' , 
                        'status'        => 'Error', 
                        'response'      => $e->getMessage(), 
                        'created_at'    => Carbon::now(), 
                        'updated_at'    => Carbon::now()
                    ];
                    FailedPayment::insert($failedData);
                }
            }
        }
        // Charge for extra minutes spent for every kind of missions
        if($totalMissionMinutes > $bookedMinutes){
            $extraMinutes = $totalMissionMinutes - $bookedMinutes;
            $baseRatePerHour = Helper::get_agent_rate($data->agent_type,$data->quick_book);
            $baseRatePerMin = $baseRatePerHour/60;
            $extraAmount = $extraMinutes*$baseRatePerMin;
            // Calculate VAT
            $vat = Helper::VAT_PERCENTAGE;
            $vatAmount = ($extraAmount*$vat)/100;
            $extraAmount = $extraAmount+$vatAmount;
            // Make Charge Payment
            $customer_stripe_id = $data->customer_details->customer_stripe_id;
            $paymentApprovalData = array(
                'customer_id' => $data->customer_id,
                'mission_id' => $mission_id,
                'amount' => $extraAmount,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            );
            // store payment data for approval 
            PaymentApproval::insert($paymentApprovalData);
        }
        // Update mission status
        $result = Mission::where('id',$mission_id)->update(['ended_at'=>$timeNow,'status'=>5]);
        if($result){
            // Update agent's availability status
            Agent::where('id',$data->agent_id)->update(['available'=>1]);
            $notification = array(
                'customer_id' => $data->customer_id,
                'mission_id' => $mission_id,
                'content' => 'messages.mission_finished',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()  
            );
            CustomerNotification::insert($notification);
            /*----Customer Notification-----*/
            $mailContent = [
                'name' => ucfirst($data->customer_details->first_name),
                'message' => trans('messages.mission_finished_at').$timeNow.'.', 
                'url' => url('customer/mission-details/view').'/'.$request->mission_id 
            ];
            $data->customer_details->user->notify(new MissionCreated($mailContent));
			PlivoSms::sendSms(['phoneNumber' => $data->customer_details->phone, 'msg' => trans('messages.agent_mission_finish', ['missionId'=> $mission_id]) ]);
            /*------------*/
            // check if this is a sub mission
            if($data->parent_id!=0){
                $parentMissionId = $data->parent_id;
                $count = Mission::where('parent_id',$data->parent_id)->where('status', '!=', 5)->count();
                // check if all other sub missions are completed or not
                if($count==0){
                    // charge the remaining amount in case of future missions
                    if($data->quick_book==0){
                        $data = Mission::where('id',$parentMissionId)->first();
                        $missionBalanceAmount = ($data->amount*70)/100;
                        // Make Charge Payment
                        $customer_stripe_id = $data->customer_details->customer_stripe_id;
                        $chargeData = [
                            'customer' => $customer_stripe_id,
                            'currency' => config('services.stripe.currency'),
                            'amount'   => $missionBalanceAmount,
                            'description' => 'Mission Remaining Charge Amount',
                        ];
                        try{
                            $charge = $this->createCharge($chargeData);
                            if($charge['status']=='succeeded'){
                                // Save data to payment history
                                $paymentDetails = [
                                    'amount'      => $missionBalanceAmount,
                                    'status'      => $charge['status'],  
                                    'charge_id'   => $charge['id'],
                                    'mission_id'  => $data->id,
                                    'customer_id' => $data->customer_details->id,
                                    'created_at'  => Carbon::now(),
                                    'updated_at'  => Carbon::now() 
                                ];
                                UserPaymentHistory::insert($paymentDetails);
                                /*----Payment Notification-----*/
                                $mailContent = [
                                    'name' => ucfirst($data->customer_details->first_name),
                                    'message' => trans('messages.payment_done_message',['amount'=>$missionBalanceAmount]), 
                                    'url' => url('customer/billing-details') 
                                ];
                                $data->customer_details->user->notify(new PaymentDone($mailContent));
                                /*--------------*/
                            }
                        }catch(\Exception $e){
                            // Store Failed Payment 
                            $failedData = [
                                'customer_id' => $data->customer_details->id, 
                                'mission_id' => $data->id, 
                                'amount' => $missionBalanceAmount, 
                                'remarks' => 'Mission Remaining Charge Amount' , 
                                'status' => 'Error', 
                                'response' => $e->getMessage(), 
                                'created_at' => Carbon::now(), 
                                'updated_at' => Carbon::now()
                            ];
                            FailedPayment::insert($failedData);
                        }
                    }
                    // update parent mission status
                    Mission::where('id',$parentMissionId)->update(['status'=>5]);
                }
            }
            $response['message'] = trans('messages.mission_finished');
            $response['delayTime'] = 2000;
            $response['modelhide'] = '#mission_action';
            $response['url'] = url('agent/missions');
            return response($this->getSuccessResponse($response));
        }else{
            $response['message'] = trans('messages.error');
            $response['delayTime'] = 2000;
            $response['url'] = url('agent/missions');
            $response['modelhide'] = '#mission_action';
            return response($this->getErrorResponse($response));
        }
    }
}
