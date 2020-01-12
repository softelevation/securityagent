<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Validators\MissionValidator;
use App\Traits\ResponseTrait;
use App\Traits\PaymentTrait;
use App\Mission;
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
        $data = Mission::where('customer_id',\Auth::user()->customer_info->id)->get();
        $statusArr = Helper::getMissionStatus();
        $statusArr = array_flip($statusArr);
        return view('customer.missions',['data'=>$data,'status_list'=>$statusArr]);
    }

    /**
     * @param $request
     * @return mixed
     * @method createMission
     * @purpose Create New Mission View 
     */
    public function createMission(){
        return view('customer.create_mission');
    }

    /**
     * @param $request
     * @return mixed
     * @method saveMission
     * @purpose Create New Mission View 
     */
    public function saveMission(Request $request){
        try{
            $validation = $this->quickMissionValidations($request);
            if($validation['status']==false){
                return response($this->getValidationsErrors($validation));
            }
            if(!(isset($request->latitude) && trim($request->latitude)!='' && isset($request->longitude) && trim($request->longitude)!='')){
                return response($this->getErrorResponse('The lat/long values of the entered location are invalid. Please clear the current location and try again!'));    
            }
            $data = array_except($request->all(),['_token']);
            // if(!(isset($request->quick_book) && $request->quick_book==1)){
            //     $startDate = date("Y-m-d", strtotime($request->start_date));
            //     $endDate   = date("Y-m-d", strtotime($request->end_date));
            //     $data['start_date'] = $startDate;
            //     $data['end_date']   = $endDate;
            // }
            $data['customer_id'] = \Auth::user()->customer_info->id;
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();
            $data['step'] = 1;
            $data['amount'] = 120;
            if($data['total_hours'] > 4){
                $data['amount'] = $data['total_hours']*30;
            }
            if(isset($data['record_id']) && $data['record_id']!=''){
                $record_id = Helper::decrypt($data['record_id']);
                unset($data['record_id'],$data['created_at']);
                $result = Mission::where('id',$record_id)->update($data);
                $missionID = $record_id;
            }else{
                $missionID = Mission::insertGetId($data);
            }
            if($missionID){
                $missionID = Helper::encrypt($missionID);
                $response['message'] = 'Mission details saved successfully';
                $response['delayTime'] = 5000;
                $response['url'] = url('customer/find-mission-agent/'.$missionID);
                return $this->getSuccessResponse($response);
            }else{
                $response['message'] = 'Something went wrong while submitting your mission details. Please try again later.';
                $response['delayTime'] = 5000;
                return $this->getErrorResponse($response);
            }
        }catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
    }

    /**
     * @param $request
     * @return mixed
     * @method createMission
     * @purpose Create New Mission View 
     */
    public function quickCreateMission(){
        return view('customer.quick_create_mission');
    }

    /**
     * @param $request
     * @return mixed
     * @method getMissionQuote
     * @purpose Get mission quote
     */
    public function findMissionAgent($id){
        $id = Helper::decrypt($id);
        $mission = Mission::where('id',$id)->first();
        $agent_type_needed = $mission->agent_type;
        $agents = Agent::whereHas('types',function($q) use($agent_type_needed){
            $q->where('agent_type',$agent_type_needed);
        })->where('status',1)->pluck('work_location_lat_long','id');
        if($agents->count() == 0){
            die('No agent available at the moment');
        }
        $agents = $agents->toArray();
        // Get Nearest Agent
        $originLocation = $mission->latitude.', '.$mission->longitude;
        $destinationLocation = implode("|",$agents);
        $response = \GoogleMaps::load('distancematrix')->setParam ([
                        'origins' =>$originLocation, 
                        'destinations' =>$destinationLocation
                    ])->get();
        $response = json_decode($response,TRUE);
        $agentsIDs = array_keys($agents);
        $_distArr = [];
        foreach($response['rows'] as $row){ 
            foreach($row['elements'] as $key=>$destination){
                $_distArr[] = $destination['distance']['value'];
            }
        }
        $key = array_keys($_distArr, min($_distArr)); 
        $nearest_agent_id = $agentsIDs[$key[0]];
        $agent = Agent::where('id',$nearest_agent_id)->first();
        $data['mission'] = $mission;
        $data['agent'] = $agent;
        return view('customer.find_mission_agent',$data);
    }

    public function proceedToPayment($id){
        $mission_id = Helper::decrypt($id);
        $mission = Mission::where('id',$mission_id)->first();
        if(!isset($mission->customer_details->customer_stripe_id) || $mission->customer_details->customer_stripe_id==null){
            // Create customer on stripe
            $user_email = $mission->customer_details->user->email;
            $customer = $this->createCustomer($user_email);
            $cus_stripe_id = $customer['id'];
            Customer::where('id',$mission->customer_details->id)->update(['customer_stripe_id'=>$cus_stripe_id]);
        }
        return view('customer.mission_payment_view',['mission'=>$mission]);
    }

    public function makeMissionPayment(Request $request){
        $amount = Helper::decrypt($request->amount);
        $mission_id = Helper::decrypt($request->mission_id);
        $mission = Mission::where('id',$mission_id)->first();
        $cardData = [
            'number'    => $request->card_number,
            'exp_month' => $request->expire_month,
            'cvc'       => $request->cvc,
            'exp_year'  => $request->expire_year,
        ];
        $customer_stripe_id = $mission->customer_details->customer_stripe_id;
        // $this->print($customer_stripe_id);
        // $card = $this->addNewCard($cardData,$customer_stripe_id);
        $chargeData = [
            'customer' => $customer_stripe_id,
            'currency' => config('services.stripe.currency'),
            'amount'   => $mission->amount,
            'description' => 'Mission Charge Amount'
        ];
        $charge = $this->createCharge($chargeData);
        if($charge['status']=='succeeded'){
            $response['message'] = 'Mission payment completed successfully';
            $response['delayTime'] = 5000;
            $response['url'] = url('customer/missions');
            return $this->getSuccessResponse($response);
        }


    }

    public function editQuickMission(Request $request, $id){
        $mission_id = Helper::decrypt($id);
        $mission = Mission::where('id',$mission_id)->first();
        $data['mission'] = $mission;
        return view('customer.quick_create_mission',$data);

    }
}
