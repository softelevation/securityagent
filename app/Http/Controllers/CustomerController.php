<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Traits\CustomerTrait;
use App\Validators\CustomerValidator;
use App\Traits\ResponseTrait;
use App\Traits\CurlTrait;
use App\Notification;
use App\Customer;
use App\Operator;
use App\MessageCenter;
use App\UserPaymentHistory;
use Carbon\Carbon;
use App\Helpers\PlivoSms;
use Session;
use Auth;

class CustomerController extends Controller
{
	use CustomerValidator, ResponseTrait, CurlTrait;

    public $limit;

    public function __construct(){
        $this->limit = 10;
    }
    
    /**
     * @param $request
     * @return mixed
     * @method index
     * @purpose Load customer signup view 
     */
    public function customerSignupView(Request $request){
        return view('customer-register');
    }

    /**
     * @param $request
     * @return mixed
     * @method customerSignupForm
     * @purpose To register as customer
     */
    public function customerSignupForm(Request $request){
    	try{
            // Check Agent Table Validation
            $validation = $this->customerSignupValidations($request);
            if($validation['status']==false){
                return response($this->getValidationsErrors($validation));
            }
			$post = array_except($request->all(),['_token','password_confirmation','captcha']);
			$result = $this->Make_Login('customer/signup',$post);
			echo '<pre>';
			print_r($result);
			die;
			if($result->status){
                $response['url'] = url('/');
				$response['message'] = trans('messages.user_registered');
				$response['delayTime'] = 5000;
				return $this->getSuccessResponse($response);
            }else{
				// return $this->getErrorResponse(trans('messages.error'));
				return $this->getErrorResponse($result->message);
            }
			
            // return $this->registerCustomer($request);
        }catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
    }

    /**
     * @param $request
     * @return mixed
     * @method index
     * @purpose Load customer signup view 
     */
    public function customerProfileView(){
		// Session::forget('session_val');
		$profile = (array)$this->Make_GET('profile')->data;
        // $profile = Customer::select('first_name','last_name','phone','image','home_address')->where('user_id',\Auth::id())->first()->toArray();
        $data['profile'] = $profile;
        return view('customer.profile',$data);
    }
	
	public function messageCenter(Request $request){
		// operator_id
		
		$user_messages = $this->Make_GET('customer/message-center/0')->data;
		$operator_profile = $this->Make_GET('operator/profile')->data;
		// echo '<pre>';
		// print_r($operator_profile);
		// die;
		// $user_messages = MessageCenter::select('message_centers.message','message_centers.message_type')->where('message_centers.user_id',Auth::id())->orderBy('message_centers.created_at','ASC')->get();
		// $customer_profile = Customer::select('first_name','last_name')->where('user_id',\Auth::id())->first();
		// $operator_profile = Operator::select('first_name','last_name')->first();
		// MessageCenter::where('user_id',Auth::user()->id)->where('message_type','send_by_op')->where('status','1')->update(array('status'=>'2'));
		$params = array();
		$params['user_id'] =Auth::id();
		$params['cus_id'] = Auth::user()->profile->id;
		$params['profile'] = '';
		$params['user_messages'] = $user_messages;
		$params['cus_profile'] = Auth::user()->profile;
		$params['operator_profile'] = $operator_profile;
        return view('customer.message_center',$params);
    }
	
	public function messageCenterPost(Request $request){
		$inputData = $request->all();
		$updateData = array('user_id'=>$request->user_id,'operator_id'=>$request->cus_id,
							'message'=>$request->send_message,'message_type'=>'send_by_cus','status'=>'1',
							'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()
						);
		MessageCenter::insert($updateData);
		$profile = Customer::select('first_name','last_name')->where('user_id',\Auth::id())->first();
		$name_op = ($profile) ? $profile->first_name.' '.$profile->last_name : 'Unknown';
		return response()->json(array('status'=>1,'message_type'=>'send_by_cus','message'=>$name_op));
	}
	
	public function patrollingMission(){
        return view('customer.patrolling_mission');
    }

    /**
     * @param $request
     * @return mixed
     * @method index
     * @purpose Process notifications
     */
    public function processNotifications(Request $request){
        $id = $request->notification_id;
        $url = $request->notification_url;
		$result = $this->Make_POST('operator/process-notification',array('notification_id'=>$request->notification_id));
        if($result){
            $response['message'] = trans('messages.please_wait');
            $response['delayTime'] = 1000;
            $response['url'] = $url;
            return response($this->getSuccessResponse($response));
        }else{
            return response($this->getErrorResponse(trans('messages.error')));
        }
    }

    /**
     * @param $request
     * @return mixed
     * @method getPaymentHistory
     * @purpose Get payment history
     */
    public function getPaymentHistory(Request $request){
		$data = $this->Make_GET('customer/billing-details')->data;
		$params = [
            'history' => $data,
            'page_no' => 1
        ];
        if(isset($request->page)){
            $params['page_no'] = $request->page; 
        }
        return view('customer.billing',$params);
    }
	
	public function testing(){
		
		// echo phpinfo();
		if(isset($_GET['message'])){
			$phone = '+'.$_GET['message'];
			$message = 'welcome to Be on time';
			PlivoSms::sendSms(['phoneNumber' => '+916239463839', 'msg' => trans($message) ]);
			// die('dddddddddddd');
			echo 'please check message';
		}else{
			echo 'something went wrong';
		}
	}
}
