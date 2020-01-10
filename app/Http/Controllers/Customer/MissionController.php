<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Validators\MissionValidator;
use App\Traits\ResponseTrait;
use App\Mission;
use App\Agent;
use Carbon\Carbon;
use App\Helpers\Helper;

class MissionController extends Controller
{
    use MissionValidator, ResponseTrait;

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
            if(!(isset($request->quick_book) && $request->quick_book==1)){
                $startDate = date("Y-m-d", strtotime($request->start_date));
                $endDate   = date("Y-m-d", strtotime($request->end_date));
                $data['start_date'] = $startDate;
                $data['end_date']   = $endDate;
            }
            $data['customer_id'] = \Auth::user()->customer_info->id;
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();
            $data['step'] = 1;
            $result = Mission::insert($data);
            if($result){
                $response['message'] = 'Mission details saved successfully';
                $response['delayTime'] = 5000;
                // $response['url'] = url('customer/missions');
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
        $misisonAmount = 120;
        if($mission->total_hours > 4){
            $misisonAmount = $mission->total_hours*30;
        }
        $data['mission_amount'] = $misisonAmount;
        return view('customer.find_mission_agent',$data);
    }


}
