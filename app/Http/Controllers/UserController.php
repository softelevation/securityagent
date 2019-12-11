<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\UserTrait;
use App\Validators\UserValidator;

class UserController extends Controller
{
	Use UserTrait, UserValidator;

	/**
     * @param $request
     * @return mixed
     * @method agentRegister
     * @purpose To register as an agent
     */
    public function agentRegister(Request $request){
    	$post = $request->all();
    	$this->print($post);
    	$validation = $this->addFeatureValidations($request);
            if($validation['status']==false){
                return response($this->getValidationsErrors($validation));
            }

    }
}
