<?php
namespace App\Validators;

use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Validator;
use App\Validators\BaseValidator;
use Illuminate\Validation\Rule;

trait UserValidator
{
    use BaseValidator;

    public $response;

    /**
     * @param   : Request $request
     * @return  : \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @method  : addMusicFileValidations
     * @purpose : Validation rule for add page
     */
    public function basicUserValidations(Request $request){
        try{
            $validations = array(
                'email' => 'required|email|unique:users',
            );
            $validator = Validator::make($request->all(),$validations);
            $this->response = $this->validateData($validator);
        }catch(\Exception $e){
            $this->response = $e->getMessage();
        }
        return $this->response;
    }

    /**
     * @param   : Request $request
     * @method  : updateProfileValidations
     * @purpose : Validation rule for add page
     */
    public function updateProfileValidations(Request $request){
        try{
            $validations = array(
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'home_address' => 'required',
                'image' => 'mimes:jpeg,jpg,png|max:5000',
            );
            $validator = Validator::make($request->all(),$validations);
            $this->response = $this->validateData($validator);
        }catch(\Exception $e){
            $this->response = $e->getMessage();
        }
        return $this->response;
    }

    /**
     * @param   : Request $request
     * @method  : updateProfileValidations
     * @purpose : Validation rule for add page
     */
    public function updatePasswordValidations(Request $request){
        try{
            $validations = array(
                'current_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            );
            $validator = Validator::make($request->all(),$validations);
            $this->response = $this->validateData($validator);
        }catch(\Exception $e){
            $this->response = $e->getMessage();
        }
        return $this->response;
    }
}
