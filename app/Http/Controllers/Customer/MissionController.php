<?php

namespace App\Http\Controllers\Customer;

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
        // try{
            $validation = $this->quickMissionValidations($request);
            if($validation['status']==false){
                return response($this->getValidationsErrors($validation));
            }
            if(!(isset($request->latitude) && trim($request->latitude)!='' && isset($request->longitude) && trim($request->longitude)!='')){
                return response($this->getErrorResponse('The lat/long values of the entered location are invalid. Please clear the current location and try again!'));    
            }
            $data = array_except($request->all(),['_token']);
            // Check if any agent available 
            $agent_type_needed = $data['agent_type'];
            $agents = Agent::whereHas('types',function($q) use($agent_type_needed){
                $q->where('agent_type',$agent_type_needed);
            })->where('status',1)->pluck('work_location_lat_long','id');
            if($agents->count() == 0){
                return response($this->getErrorResponse('No agent available at the moment. Please try again later!'));    
            }
            $agents = $agents->toArray();
            // Get Nearest Agent
            $originLocation = $data['latitude'].', '.$data['longitude'];
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
                    if(trim(strtolower($destination['status']))=='ok'){
                        $_distArr[] = $destination['distance']['value'];
                    }
                }
            }
            if(empty($_distArr)){
                return response($this->getErrorResponse('No agent available for this location at the moment. Please try again later!'));
            }
            $key = array_keys($_distArr, min($_distArr)); 
            $nearest_agent_id = $agentsIDs[$key[0]];
            // if(!(isset($request->quick_book) && $request->quick_book==1)){
            //     $startDate = date("Y-m-d", strtotime($request->start_date));
            //     $endDate   = date("Y-m-d", strtotime($request->end_date));
            //     $data['start_date'] = $startDate;
            //     $data['end_date']   = $endDate;
            // }
            $data['agent_id'] = $nearest_agent_id;
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
        // }catch(\Exception $e){
        //     return response($this->getErrorResponse($e->getMessage()));
        // }
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
        $agent = Agent::where('id',$mission->agent_id)->first();
        $data['mission'] = $mission;
        $data['agent'] = $agent;
        return view('customer.find_mission_agent',$data);
    }

    /**
     * @param $id
     * @return mixed
     * @method proceedToPayment
     * @purpose View Payment and Mission Details
     */
    public function proceedToPayment($id){
        $mission_id = Helper::decrypt($id);
        $mission = Mission::where('id',$mission_id)->first();
        $data['mission'] = $mission;
        if(!isset($mission->customer_details->customer_stripe_id) || $mission->customer_details->customer_stripe_id==null){
            // Create customer on stripe
            $user_email = $mission->customer_details->user->email;
            $customer = $this->createCustomer($user_email);
            $cus_stripe_id = $customer['id'];
            Customer::where('id',$mission->customer_details->id)->update(['customer_stripe_id'=>$cus_stripe_id]);
        }else{
            // Get added card's of customer 
            $addedCards = $this->getCardsList($mission->customer_details->customer_stripe_id);
            $data['cards'] = $addedCards;
        }
        return view('customer.mission_payment_view',$data);
    }

    /**
     * @param $request
     * @return mixed
     * @method makeMissionPayment
     * @purpose Add new card and make payment
     */
    public function makeMissionPayment(Request $request){
        try{
            $amount = Helper::decrypt($request->amount);
            $mission_id = Helper::decrypt($request->mission_id);
            $mission = Mission::where('id',$mission_id)->first();
            $customer_stripe_id = $mission->customer_details->customer_stripe_id;
            $last4digit = substr($request->card_number, -4);
            // Get added card's list
            $addedCards = $this->getCardsList($customer_stripe_id);
            foreach($addedCards['data'] as $card){
                // If entered card is already been added
                if($card['last4']==$last4digit){
                    return $this->getErrorResponse('This card has already been added.');
                }
            }
            // Add New Card
            $cardData = [
                'number'    => $request->card_number,
                'exp_month' => $request->expire_month,
                'cvc'       => $request->cvc,
                'exp_year'  => $request->expire_year,
            ];
            $card = $this->addNewCard($cardData,$customer_stripe_id);
            // Make Charge Payment
            $chargeData = [
                'customer' => $customer_stripe_id,
                'currency' => config('services.stripe.currency'),
                'amount'   => $mission->amount,
                'description' => 'Mission Charge Amount'
            ];
            $charge = $this->createCharge($chargeData);
            if($charge['status']=='succeeded'){
                // Save data to payment history
                $paymentDetails = [
                    'amount'      => $mission->amount,
                    'status'      => $charge['status'],  
                    'charge_id'   => $charge['id'],
                    'mission_id'  => $mission_id,
                    'customer_id' => $mission->customer_details->id,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now() 
                ];
                UserPaymentHistory::insert($paymentDetails);
                // Update Mission Data
                Mission::where('id',$mission_id)->update(['payment_status'=>1,'status'=>3]);
                $response['message'] = 'Mission payment completed successfully';
                $response['delayTime'] = 5000;
                $response['url'] = url('customer/missions');
                return $this->getSuccessResponse($response);
            }else{
                $response['message'] = 'Unknown error !';
                $response['delayTime'] = 2000;
                $response['url'] = url('customer/missions');
                $response['data'] = $charge;
                return $this->getErrorResponse($response);
            }
        }catch(\Exception $e){
            return $this->getErrorResponse($e->getMessage());
        }
    }

    /**
     * @param $request, $id
     * @return mixed
     * @method editQuickMission
     * @purpose Edit mission details
     */
    public function editQuickMission(Request $request, $id){
        $mission_id = Helper::decrypt($id);
        $mission = Mission::where('id',$mission_id)->first();
        $data['mission'] = $mission;
        return view('customer.quick_create_mission',$data);

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
        return view('customer.view_mission_details',$data);
    }

    /**
     * @param $request
     * @return mixed
     * @method makeCardPayment
     * @purpose Make payment from added cards
     */
    public function makeCardPayment(Request $request){
        try{
            $card_id = $request->card_id;
            $mission_id = Helper::decrypt($request->mission_id);
            $mission = Mission::where('id',$mission_id)->first();
            // Make Charge Payment
            $customer_stripe_id = $mission->customer_details->customer_stripe_id;
            $chargeData = [
                'customer' => $customer_stripe_id,
                'currency' => config('services.stripe.currency'),
                'amount'   => $mission->amount,
                'description' => 'Mission Charge Amount',
                'source'    => $card_id
            ];
            $charge = $this->createCharge($chargeData);
            if($charge['status']=='succeeded'){
                // Save data to payment history
                $paymentDetails = [
                    'amount'      => $mission->amount,
                    'status'      => $charge['status'],  
                    'charge_id'   => $charge['id'],
                    'mission_id'  => $mission_id,
                    'customer_id' => $mission->customer_details->id,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now() 
                ];
                UserPaymentHistory::insert($paymentDetails);
                // Update Mission Data
                Mission::where('id',$mission_id)->update(['payment_status'=>1,'status'=>3]);
                $response['message'] = 'Mission payment completed successfully';
                $response['delayTime'] = 5000;
                $response['url'] = url('customer/missions');
                return $this->getSuccessResponse($response);
            }else{
                $response['message'] = 'Unknown error !';
                $response['delayTime'] = 2000;
                $response['url'] = url('customer/missions');
                $response['data'] = $charge;
                return $this->getErrorResponse($response);
            }
        }catch(\Exception $e){
            return $this->getErrorResponse($e->getMessage());
        }
    }
}
