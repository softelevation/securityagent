<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validators\OperatorValidator;
use App\Traits\ResponseTrait;
use Auth;
use App\Agent;


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
        	if (Auth::attempt($credentials)) {
            	$response['message'] = 'Login Success.';
	            $response['delayTime'] = 2000;
	            $response['url'] = url('operator/dashboard');
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
    public function loadDashboardView(){
    	return view('operator.dashboard');
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
}
