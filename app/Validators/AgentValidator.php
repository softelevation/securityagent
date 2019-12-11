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
                'password'      => 'required|confirmed|min:6',
                'id_proof'      => 'required',
                'agent_number_proof' => 'required',
                'agent_type'    => 'required',
                'city'          => 'required',
                'work_location' => 'required',
            );
            $validator = Validator::make($request->all(),$validations);
            $this->response = $this->validateData($validator);
        }catch(\Exception $e){
            $this->response = $e->getMessage();
        }
        return $this->response;
    }
}
