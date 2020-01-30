<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CustomerTrait;
use App\Validators\CustomerValidator;
use App\Traits\ResponseTrait;

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
}
