<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CustomerTrait;
use App\Validators\CustomerValidator;
use App\Traits\ResponseTrait;
use App\CustomerNotification;

class CustomerController extends Controller
{
	use CustomerValidator, CustomerTrait, ResponseTrait;
    
    /**
     * @param $request
     * @return mixed
     * @method index
     * @purpose Load customer signup view 
     */
    public function customerSignupView(){
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
        return view('customer.profile');
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
}
