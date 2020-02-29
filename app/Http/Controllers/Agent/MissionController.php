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
use App\Agent;
use App\RejectedMission;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\CustomerNotification;
use App\Notifications\MissionCreated;

class MissionController extends Controller
{
    use MissionValidator, ResponseTrait, PaymentTrait;

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
     * @method viewMissionRequests
     * @purpose View Mission Request's List 
     */
    public function viewMissionRequests(){
        $missions = Mission::where('agent_id',\Auth::user()->agent_info->id)
                            ->where('status',0)
                            ->where('payment_status',1)
                            ->paginate($this->limit);
        $params = [
            'data' => $missions,
            'limit' => $this->limit,
            'page_no' => 1
        ];
        if(isset($request->page)){
            $params['page_no'] = $request->page; 
        }
        return view('agent.mission_requests',$params);
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
            $mission = Mission::where('id',$mission_id)->first();
            // Check if mission request is expired or not
            $timeFrom = Carbon::createFromFormat('Y-m-d H:i:s', $mission->updated_at);
            $timeTo = Carbon::now();
            $diffMinutes = $timeFrom->diffInMinutes($timeTo);
             
            if($action==1){
                $result = Mission::where('id',$mission_id)->update(['status'=>3]);
                if($result){
                    $response['message'] = 'Mission request accepted successfully';
                    $response['delayTime'] = 2000;
                    $response['modelhide'] = '#mission_action';
                    $response['url'] = url('agent/mission-requests');
                    return response($this->getSuccessResponse($response));
                }else{
                    return response($this->getErrorResponse('Something went wrong!'));
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
                        $response['message'] = 'Mission request rejected successfully';
                        $response['delayTime'] = 2000;
                        $response['modelhide'] = '#mission_action';
                        $response['url'] = url('agent/mission-requests');
                        return response($this->getSuccessResponse($response));
                    }else{
                        return response($this->getErrorResponse('Something went wrong!'));    
                    }
                }else{
                    return response($this->getErrorResponse('Something went wrong while adding mission to rejected list!'));
                }
            }
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
            $result = Mission::where('id',$mission_id)->update(['started_at'=>$timeNow,'status'=>4]);
            if($result){
                $data = Mission::where('id',$mission_id)->first();
                Agent::where('id',$data->agent_id)->update(['available'=>2]);
                $notification = array(
                    'customer_id' => $data->customer_id,
                    'mission_id' => $mission_id,
                    'content' => 'Your mission has started now.',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()  
                );
                CustomerNotification::insert($notification);
                /*----Customer Notification-----*/
                $mailContent = [
                    'name' => ucfirst($data->customer_details->first_name),
                    'message' => 'Your mission has been started now at '.$timeNow.'.', 
                    'url' => url('customer/mission-details/view').'/'.$request->mission_id 
                ];
                $data->customer_details->user->notify(new MissionCreated($mailContent));
                /*------------*/
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
        $mission_id = Helper::decrypt($request->mission_id);
        $data = Mission::where('id',$mission_id)->first();
        $timeNow = Carbon::now();
        // check if extra hours spent on mission
        $missionStartTime = Carbon::create($data->started_at);
        $missionEndTime = $timeNow;
        $totalMissionMinutes = $missionStartTime->diffInMinutes($missionEndTime);
        $bookedMinutes = $data->total_hours*60;
        // Charge for extra minutes spent
        if($totalMissionMinutes > $bookedMinutes){
            $extraMinutes = $totalMissionMinutes - $bookedMinutes;
            $baseRatePerHour = Helper::BASE_AGENT_RATE;
            $baseRatePerMin = $baseRatePerHour/60;
            $extraAmount = $extraMinutes*$baseRatePerMin;
            // Make Charge Payment
            $customer_stripe_id = $data->customer_details->customer_stripe_id;
            $chargeData = [
                'customer' => $customer_stripe_id,
                'currency' => config('services.stripe.currency'),
                'amount'   => $extraAmount,
                'description' => 'Extra Mission Charge Amount',
            ];
            try{
                $charge = $this->createCharge($chargeData);
                if($charge['status']=='succeeded'){
                    // Save data to payment history
                    $paymentDetails = [
                        'amount'      => $extraAmount,
                        'status'      => $charge['status'],  
                        'charge_id'   => $charge['id'],
                        'mission_id'  => $mission_id,
                        'customer_id' => $data->customer_details->id,
                        'created_at'  => Carbon::now(),
                        'updated_at'  => Carbon::now() 
                    ];
                    UserPaymentHistory::insert($paymentDetails);
                }else{
                    // Store Failed Payment 
                    $failedData = [
                        'customer_id' => $data->customer_details->id, 
                        'mission_id' => $mission_id, 
                        'amount' => $extraAmount, 
                        'remarks' => 'Extra Mission Amount' , 
                        'status' => $charge['status'], 
                        'response' => json_encode($charge), 
                        'created_at' => Carbon::now(), 
                        'updated_at' => Carbon::now()
                    ];
                    FailedPayment::insert($failedData);
                }
            }catch(\Exception $e){
                // Store Failed Payment 
                $failedData = [
                    'customer_id' => $data->customer_details->id, 
                    'mission_id' => $mission_id, 
                    'amount' => $extraAmount, 
                    'remarks' => 'Extra Mission Amount' , 
                    'status' => 'Error', 
                    'response' => $e->getMessage(), 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now()
                ];
                FailedPayment::insert($failedData);
            }
        }
        $result = Mission::where('id',$mission_id)->update(['ended_at'=>$timeNow,'status'=>5]);
        if($result){
            Agent::where('id',$data->agent_id)->update(['available'=>1]);
            $notification = array(
                'customer_id' => $data->customer_id,
                'mission_id' => $mission_id,
                'content' => 'Your mission has finished now.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()  
            );
            CustomerNotification::insert($notification);
            /*----Customer Notification-----*/
            $mailContent = [
                'name' => ucfirst($data->customer_details->first_name),
                'message' => 'Your mission has been finished now at '.$timeNow.'.', 
                'url' => url('customer/mission-details/view').'/'.$request->mission_id 
            ];
            $data->customer_details->user->notify(new MissionCreated($mailContent));
            /*------------*/
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
    }
}
