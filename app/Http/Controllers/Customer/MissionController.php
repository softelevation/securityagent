<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Validators\MissionValidator;
use App\Traits\ResponseTrait;
use App\Mission;
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
        $data = Mission::where('customer_id',\Auth::user()->id)->get();
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
            $validation = $this->createMissionValidations($request);
            if($validation['status']==false){
                return response($this->getValidationsErrors($validation));
            }
            if(!(isset($request->latitude) && trim($request->latitude)!='' && isset($request->longitude) && trim($request->longitude)!='')){
                return response($this->getErrorResponse('The lat/long values of the entered location are invalid. Please clear the current location and try again!'));    
            }
            $startDate = date("Y-m-d", strtotime($request->start_date));
            $endDate   = date("Y-m-d", strtotime($request->end_date));
            $data = array_except($request->all(),['_token']);
            $data['start_date'] = $startDate;
            $data['end_date']   = $endDate;
            $data['customer_id'] = \Auth::user()->id;
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();
            $result = Mission::insert($data);
            if($result){
                $response['message'] = 'Your mission has been submitted successfully for the verification process.';
                $response['delayTime'] = 5000;
                $response['url'] = url('customer/missions');
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
}
