<?php
namespace App\Validators;

use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Validator;
use App\Validators\BaseValidator;
use Illuminate\Validation\Rule;

trait MissionValidator
{
    use BaseValidator;

    /**
     * @param   : Request $request
     * @return  : \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @method  : createMissionValidations
     * @purpose : Validation rule for create new mission
     */
    public function createMissionValidations(Request $request){
        try{
            $validations = array(
            	'title'			=> 'required',
                'location' 		=> 'required',
                'start_date'	=> 'required',
                'end_date' 		=> 'required',
                'agent_type'    => 'required',
                'description' 	=> 'required',
            );
            $validator = Validator::make($request->all(),$validations);
            $this->response = $this->validateData($validator);
        }catch(\Exception $e){
            $this->response = $e->getMessage();
        }
        return $this->response;
    }
}
