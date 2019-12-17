<?php
namespace App\Validators;

use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Validator;
use App\Validators\BaseValidator;
use Illuminate\Validation\Rule;

trait AgentValidator
{
    use BaseValidator;

    public $response;

    /**
     * @param   : Request $request
     * @return  : \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @method  : addMusicFileValidations
     * @purpose : Validation rule for add page
     */
    public function agentSignupValidations(Request $request){
        try{
            $validations = array(
                'first_name'    => 'required',
                'last_name'     => 'required',
                'email'         => 'required|email|unique:agents',
                'phone'         => 'required',
                'identity_card'      => 'required',
                'social_security_number' => 'required',
                'agent_type'    => 'required',
                'cv'    => 'required',
                'iban'    => 'required',
                // 'cnaps_number'          => 'required',
                'home_address'          => 'required',
                'work_location_address' => 'required',
            );
            $validator = Validator::make($request->all(),$validations);
            $this->response = $this->validateData($validator);
        }catch(\Exception $e){
            $this->response = $e->getMessage();
        }
        return $this->response;
    }
}
