<?php
namespace App\Validators;

use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Validator;
use App\Validators\BaseValidator;
use Illuminate\Validation\Rule;

trait CustomerValidator
{
    use BaseValidator;

    public $response;

    /**
     * @param   : Request $request
     * @return  : \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @method  : addMusicFileValidations
     * @purpose : Validation rule for add page
     */
    public function customerSignupValidations(Request $request){
        try{ 
            $validations = array(
                'first_name'    => 'required',
                'last_name'     => 'required',
                'email'         => 'required|email|unique:users',
                'phone'         => 'required',
                'home_address'  => 'required',
                'customer_type' => 'required',
                'password'      => 'required|confirmed|min:8',
                'captcha'       => 'required|captcha',
                'terms_conditions' => 'required',
            );
            $validator = Validator::make($request->all(),$validations);
            $this->response = $this->validateData($validator);
        }catch(\Exception $e){
            $this->response = $e->getMessage();
        }
        return $this->response;
    }
}
