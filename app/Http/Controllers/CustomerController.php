<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CustomerTrait;
use App\Validators\CustomerValidator;
use App\Traits\ResponseTrait;
use App\CustomerNotification;
use App\Customer;
use App\Operator;
use App\MessageCenter;
use App\UserPaymentHistory;
use Carbon\Carbon;
use Auth;

class CustomerController extends Controller
{
	use CustomerValidator, CustomerTrait, ResponseTrait;

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
            return $this->registerCustomer($request);
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
        $profile = Customer::select('first_name','last_name','phone','image','home_address')->where('user_id',\Auth::id())->first()->toArray();
        $data['profile'] = $profile;
        return view('customer.profile',$data);
    }
	
	public function messageCenter(Request $request){
		$user_messages = MessageCenter::select('operators.user_id','operators.first_name','operators.last_name','message_centers.message','message_centers.message_type')->join('operators','operators.user_id','message_centers.operator_id')->where('message_centers.user_id',Auth::id())->orderBy('message_centers.created_at','ASC')->get();
		$customer_profile = Customer::select('first_name','last_name')->where('user_id',\Auth::id())->first();
		$params = array();
		$params['user_id'] =Auth::id();
		$params['cus_id'] = '1';
		$params['profile'] = '';
		$params['user_messages'] = $user_messages;
		$params['cus_profile'] = $customer_profile;
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
        $result = CustomerNotification::where('id',$id)->update(['status'=>1]);
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
        $customer_id = Auth::user()->customer_info->id;
        $data = UserPaymentHistory::select('user_payment_histories.id','user_payment_histories.amount','user_payment_histories.status','user_payment_histories.created_at','missions.title','missions.id as mid')->join('missions','missions.id','user_payment_histories.mission_id')->where('user_payment_histories.customer_id',$customer_id)->orderBy('user_payment_histories.id','DESC')->paginate($this->limit);
        $params = [
            'history' => $data,
            'limit' => $this->limit,
            'page_no' => 1
        ];
        if(isset($request->page)){
            $params['page_no'] = $request->page; 
        }
        return view('customer.billing',$params);
    }
}
