<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CustomerTrait;
use App\Validators\CustomerValidator;
use App\Traits\ResponseTrait;
use App\CustomerNotification;
use App\Customer;
use App\UserPaymentHistory;
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
            $response['message'] = 'Please wait...';
            $response['delayTime'] = 1000;
            $response['url'] = $url;
            return response($this->getSuccessResponse($response));
        }else{
            return response($this->getErrorResponse('Something went wrong!'));
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
        $data = UserPaymentHistory::where('customer_id',$customer_id)->orderBy('id','DESC')->paginate($this->limit);
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
