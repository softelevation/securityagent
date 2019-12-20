<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validators\OperatorValidator;
use App\Traits\ResponseTrait;
use Auth;
use App\Agent;
use App\Helpers\Helper;

class OperatorController extends Controller
{

	use OperatorValidator, ResponseTrait;

	/**
     * @return mixed
     * @method login
     * @purpose Load login page view 
     */
    public function login(){
    	return view('operator.login');
    }


    /**
     * @return mixed
     * @method operatorLogin
     * @purpose Authenticate operator login
     */
    public function operatorLogin(Request $request){
    	try{
	    	$validation = $this->loginValidation($request);
	        if($validation['status']==false){
	            return response($this->getValidationsErrors($validation));
	        }
	        $credentials = $request->only('email', 'password');
            $credentials['role_id'] = Helper::get_role_id('operator');
        	if (Auth::attempt($credentials)) {
            	$response['message'] = 'Login Success.';
	            $response['delayTime'] = 2000;
	            $response['url'] = url('operator/profile');
	            return $this->getSuccessResponse($response);
        	}else{
        		return response($this->getErrorResponse('Invalid login credentials !'));	
        	}

    	}catch(\Exception $e){
    		return response($this->getErrorResponse($e->getMessage()));
    	}
    }

    /**
     * @return mixed
     * @method loadDashboardView
     * @purpose Load dashboard view
     */
    public function loadProfileView(){
    	return view('operator.profile');
    }

    /**
     * @return mixed
     * @method loadPendingAgentsView
     * @purpose Load pending agents list view
     */
    public function loadPendingAgentsView(){
    	$agents = Agent::where('status',0)->paginate(10);
    	return view('operator.agents_pending',['data'=>$agents]);
    }

    /**
     * @return mixed
     * @method viewPendingAgentDetails
     * @purpose View details of verification pending agent
     */
    public function viewPendingAgentDetails($en_id){
        $id = Helper::decrypt($en_id);
        $agent = Agent::where('id',$id)->first();
        return view('operator.pending_agent_details',['data'=>$agent]);
    }

    
}
