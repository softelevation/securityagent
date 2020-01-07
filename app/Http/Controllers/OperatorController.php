<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validators\OperatorValidator;
use App\Traits\ResponseTrait;
use App\Traits\HelperTrait;
use Auth;
use App\Agent;
use App\User;
use App\Customer;
use App\Mission;
use App\Helpers\Helper;
use Hash;

class OperatorController extends Controller
{

	use OperatorValidator, ResponseTrait;
    
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
                $message = "<b>Congratulations</b><br>Your agent verification is completed successfully and your details are approved.<br><br>Your login credentials are:<br><br>Email:".$user->email."<br> Password:".$password1;
            }else{
                $message = "Your agent verification is completed successfully and your details are rejected.<br><br>Thanks";
            }
            $templateName = 'emails.general';
            $data['message'] = $message;
            $toEmail = $user->email;
            $toName = $user->email;
            $subject = "Agent Verification";
            Helper::sendCommonMail($templateName,$data,$toEmail,$toName,$subject);
            $response['message'] = 'Agent verification completed successfully.';
            $response['delayTime'] = 2000;
            $response['url'] = url('operator/agents/pending');
            return $this->getSuccessResponse($response);
        }else{
            return response($this->getErrorResponse('Something went wrong. Try again later !'));
        }
    }

    /**
     * @return mixed
     * @method loadPendingCustomerView
     * @purpose Load pending customer list view
     */
    public function loadPendingCustomerView(){
        $customers = Customer::where('status',0)->orderBy('id','DESC')->paginate(10);
        return view('operator.customers_pending',['data'=>$customers]);
    }

    /**
     * @return mixed
     * @method viewPendingCustomerDetails
     * @purpose View details of verification pending agent
     */
    public function viewPendingCustomerDetails($en_id){
        $id = Helper::decrypt($en_id);
        $customer = Customer::where('id',$id)->first();
        return view('operator.pending_customer_details',['data'=>$customer]);
    }

    /**
     * @return mixed
     * @method agentVerificationAction
     * @purpose To process agent verification
     */
    public function customerVerificationAction(Request $request){
        $status = $request->verify_status;
        $user_id = Helper::decrypt($request->user_id);
        $result = Customer::where('user_id',$user_id)->update(['status'=>$status]);
        if($result){
            $password1 = Helper::generateToken(8);
            $password = Hash::make($password1);
            User::where('id',$user_id)->update(['password'=>$password]);
            $user = User::where('id',$user_id)->first();
            if($status==1){
                $message = "<b>Congratulations</b><br>Your profile verification is completed successfully and your details are approved.<br><br>Your login credentials are:<br><br>Email: ".$user->email."<br> Password: ".$password1;
            }else{
                $message = "Your profile verification is completed successfully and your details are rejected.<br><br>Thanks";
            }
            $templateName = 'emails.general';
            $data['message'] = $message;
            $toEmail = $user->email;
            $toName = $user->email;
            $subject = "Customer Verification";
            Helper::sendCommonMail($templateName,$data,$toEmail,$toName,$subject);
            $response['message'] = 'Customer verification completed successfully.';
            $response['delayTime'] = 2000;
            $response['url'] = url('operator/customers/pending');
            return $this->getSuccessResponse($response);
        }else{
            return response($this->getErrorResponse('Something went wrong. Try again later !'));
        }
    }

    /**
     * @return mixed
     * @method missionsList
     * @purpose To get all missions list
     */
    public function missionsList(){
        $missions = Mission::orderBy('id','DESC')->paginate(10);
        $data['missions'] = $missions;
        return view('operator.missions',$data);
    }

    /**
     * @return mixed
     * @method verifyMission
     * @purpose To verify a mission
     */
    public function verifyMission(Request $request, $id){
        $id = Helper::decrypt($id);
        $mission = Mission::where('id',$id)->first();
        return view('operator.verify_mission',['data'=>$mission]);
    }
    
}
