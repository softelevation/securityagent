<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, ResponseTrait;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @return mixed
     * @method operatorLogin
     * @purpose Authenticate operator login
     */
    public function allInOneLogin(Request $request){
        try{
            // $validation = $this->loginValidations($request);
            // if($validation['status']==false){
            //     return response($this->getValidationsErrors($validation));
            // }
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                switch(Auth::user()->role_id){
                    // Customer
                    case 1:
                        $response['url'] = url('customer/profile');
                    break;
                    // Agent
                    case 2:
                        $response['url'] = url('agent/profile');
                    break;
                    // Operator
                    case 3:
                        $response['url'] = url('operator/profile');
                    break;
                    // Admin
                    case 4:
                        $response['url'] = url('agent/profile');
                    break;
                }
                $response['message'] = 'Login Success.';
                $response['delayTime'] = 2000;
                return $this->getSuccessResponse($response);
            }else{
                return response($this->getErrorResponse('Invalid login credentials !'));    
            }

        }catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
    }
}
