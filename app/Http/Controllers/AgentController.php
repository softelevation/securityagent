<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AgentTrait;
use App\Validators\AgentValidator;
use App\Traits\ResponseTrait;


class AgentController extends Controller
{
	use AgentValidator, AgentTrait, ResponseTrait;
    
    /**
     * @param $request
     * @return mixed
     * @method agentRegister
     * @purpose To register as an agent
     */
    public function signup(Request $request){
    	try{
        	$validation = $this->agentSignupValidations($request);
            if($validation['status']==false){
                return response($this->getValidationsErrors($validation));
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
    public function showAvailableAgents(){
        $agents = $this->getAvailableAgents();
        // $this->print($agents);
        return view('available_agents',['data'=>json_encode($agents)]);
    }

}
