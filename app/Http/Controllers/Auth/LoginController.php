<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\MissionTrait;
use Illuminate\Support\Facades\Session;
use App\Helpers\Helper;
use Auth;

class LoginController extends Controller
{
    use MissionTrait;
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

    public function loginView(){
        if(\Auth::check()){
            $currentRoleID = \Auth::user()->role_id;
            switch($currentRoleID){
                case 1:
                    return redirect('customer/missions');        
                break;
                case 2:
                    return redirect('agent/missions');        
                break;
                case 3:
                    return redirect('operator/missions');        
                break;
                case 4:
                    return redirect('admin/missions');        
                break;
            }   
        }else{
            return view('login');
        }
    }

    /**
     * @return mixed
     * @method operatorLogin
     * @purpose Authenticate operator login
     */
    public function allInOneLogin(Request $request){
            // $this->print($request->all());
        try{
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $response['message'] = trans('messages.login_success');
                switch(Auth::user()->role_id){
                    // Customer
                    case 1:
                        $response['url'] = url('customer/missions');
                        if(Session::has('mission')){
                            $mission = Session::get('mission');
                            if(isset($mission['agent_id'])){
                                $mission_id = $this->saveQuickMissionDetails($mission);
                                if($mission_id){
                                    Session::forget('mission');
                                    $mission_id = Helper::encrypt($mission_id);
                                    $response['url'] = url('customer/find-mission-agent/'.$mission_id);
                                }
                            }
                        }
                    break;
                    // Agent
                    case 2:
                        if(Auth::user()->agent_info->status==1){
                            $response['url'] = url('agent/missions');
                        }else{
                            Auth::logout();
                            return response($this->getErrorResponse(trans('messages.invalid_login')));
                        }

                    break;
                    // Operator
                    case 3:
                        $response['url'] = url('operator/missions');
                    break;
                    // Admin
                    case 4:
                        $response['url'] = url('admin/missions');
                    break;
                }
                $response['delayTime'] = 2000;
                return $this->getSuccessResponse($response);
            }else{
                return response($this->getErrorResponse(trans('messages.invalid_login')));    
            }

        }catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
    }
}
