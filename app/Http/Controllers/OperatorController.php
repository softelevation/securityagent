<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validators\OperatorValidator;
use App\Traits\ResponseTrait;
use App\Traits\HelperTrait;
use Auth;
use App\Agent;
use App\User;
use App\Helpers\Helper;
use Hash;

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
    	$agents = Agent::where('status',0)->orderBy('id','DESC')->paginate(10);
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
                $message = "<b>Congratulations</b><br>Your agent verification is completed successfully and your details are approved.<br><br>Your login credentials are:<br><br>Email:".$user->email." Password:".$user->password1;
            }else{
                $message = "Your agent verification is completed successfully and your details are rejected.<br><br>Thanks";
            }
            $templateName = 'emails.general';
            $data['message'] = $message;
            $toEmail = $user->email;
            $toName = $user->email;
            $subject = "Agent Verification";
            // Helper::sendCommonMail($templateName,$data,$toEmail,$toName,$subject);
            $response['message'] = 'Agent verification completed successfully.';
            $response['delayTime'] = 2000;
            $response['url'] = url('operator/agents/pending');
            return $this->getSuccessResponse($response);
        }else{
            return response($this->getErrorResponse('Something went wrong. Try again later !'));
        }
    }
    
}
