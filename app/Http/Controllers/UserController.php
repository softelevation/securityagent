<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validators\UserValidator;
use App\Traits\ResponseTrait;
use App\Traits\CurlTrait;
use App\Customer;
use App\Operator;
use App\Agent;
use App\User;
use Session;
use App\Helpers\Helper;
use App\UserPaymentHistory;
use App\Notifications\ResetPasswordNotification;
use Hash;
use Auth;
use DB;

class UserController extends Controller
{
	use UserValidator, ResponseTrait, CurlTrait;


    /**
     * @param $request
     * @return mixed
     * @method updateProfileDetails
     * @purpose Update profile details
     */
    public function updateProfileDetails(Request $request){
        try{
            $post = array_except($request->all(),['_token','role_id','image']);
			// if(Session::has('session_val')){
				// $session_value = Session::get('session_val');
				// $post = array_merge($post,$session_value);
			// }
			if($request->profile_image){
				// $session_value = Session::get('session_val');
				$post['image'] = $request->profile_image;
				unset($post['profile_image']);
			}
            $validation = $this->updateProfileValidations($request);
            if($validation['status']==false){
                return response($this->getValidationsErrors($validation));
            }
            $role = \Auth::user()->role_id;
            // $user_id = \Auth::user()->id;
            // Upload image
            if(isset($request->image) && $request->image!=""){
                $image = $request->file('image');
				// $request->file('image');   
                // $fileName = time().'.'.$image->getClientOriginalExtension();
                // $filePath = public_path('profile_images');
                // $uploadStatus = $image->move($filePath,$fileName);
                // $post['image'] = "@$image";
            }
            switch ($role) {
                case 1:
                    // Update customer table
					$result = $this->Make_POST('customer/profile',$post);
					$userProfile = (array)Session::get('userProfile');
					$userProfile_array = (object)array_merge($userProfile,$post);
					Session::put('userProfile',$userProfile_array);
                    $url = url('customer/profile'); 
                    break;
                case 2:
                    // Update customer table
					$result = $this->Make_POST('agent/profile',$post);
					Session::put('userProfile',$result->data);
                    $url = url('agent/profile'); 
                    break;
                case 3:
					$result = $this->Make_POST('operator/profile',$post);
					Session::put('userProfile',$result->data);
                    $url = url('operator/profile'); 
                    break;
            }
            if($result){
                $response['message'] = trans('messages.profile_updated');
                $response['delayTime'] = 3000;
                $response['url'] = $url;
                return response($this->getSuccessResponse($response));
            }else{
                return response($this->getErrorResponse(trans('messages.error')));
            }
        }catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }

    }
	
	
	public function uploadMedia(Request $request){
		$session_value = Session::get('session_val');
		if(!empty($session_value)){
			Session::put('session_val',array($request->name=>$request->value));
			
		}else{
			Session::put('session_val',array($request->name=>$request->value));
		}
		// return true;
	}

    /**
     * @param $request
     * @return mixed
     * @method updateProfileDetails
     * @purpose Update profile details
     */
    public function updatePassword(Request $request){
        try{
            $post = array_except($request->all(),'_token');
            $validation = $this->updatePasswordValidations($request);
            if($validation['status']==false){
                return response($this->getValidationsErrors($validation));
            }
            $current_password = $request->current_password;
            $new_password = $request->new_password;
			$result = $this->Make_POST('change-password',array('current_password'=>$current_password,'new_password'=>$new_password,'confirm_password'=>$new_password));
          
            // if(Hash::check($current_password, Auth::user()->password)){
                // $new_password = Hash::make($new_password);
                // $result = User::where('id',Auth::id())->update(['password'=>$new_password]);
                // if($result){
                    // $response['message'] = trans('messages.password_changed');
                    // $response['delayTime'] = 5000;
                    // $response['url'] = url('/logout');
                    // return response($this->getSuccessResponse($response));
                // }
			
			if($result->status){
				$response['message'] = $result->message;
                $response['delayTime'] = 5000;
                $response['url'] = url('/logout');
                return response($this->getSuccessResponse($response));
            }else{
                return response($this->getErrorResponse(trans('messages.wrong_current_password')));
            }
            
        }catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
    }

    public function downloadPaymentReceipt($id){
        $id = Helper::decrypt($id);
		$profile = $this->Make_GET('profile');
		$mission = $this->Make_GET('customer/mission-details/'.$id);
		$customPaper = array(0,0,500.00,850.80);
        $pdf = \PDF::loadView('pdf.payment_receipt', ['data'=>$mission->data,'profile'=>$profile->data])->setPaper($customPaper, 'landscape');
        return $pdf->download('invoice.pdf');
        // return view('pdf.payment_receipt',['data'=>$data]);
    }

    public function ResetPasswordRequest(Request $request){
        $validation = $this->resetPasswordValidations($request);
        if($validation['status']==false){
            return response($this->getValidationsErrors($validation));
        }
		$result = $this->Make_Login('forgot-password',array('email'=>$request->email));
        if($result->status){
                $response['message'] = trans('messages.reset_pwd_link_sent');
                $response['delayTime'] = 2000;
				$response['url'] = $result->data->url;
                return response($this->getSuccessResponse($response));
        }else{
            return response($this->getErrorResponse(trans('messages.email_not_exists')));
        }
    }

    public function ChangePasswordView($token){
        // $data = DB::table('password_resets')->where('token',$token)->first();
        if($token){
            $param['token'] = $token;
            return view('set_password',$param);
        }else{
            abort('404');
        }
    }

    public function SetNewPassword(Request $request){
        try{
            $validation = $this->setNewPasswordValidations($request);
            if($validation['status']==false){
                return response($this->getValidationsErrors($validation));
            }
			$result = $this->Make_Login('forgot-update-password',array('email_token'=>$request->email_token,'password'=>$request->password,'confirm_password'=>$request->password));
			// echo '<pre>';
			// print_r($request->all());
			// die;
            // $token = $request->email_token;
            // $data = DB::table('password_resets')->where('token',$token)->first();
            // $email = $data->email;
            // $password = Hash::make($request->password);
            // $result = User::where('email',$email)->update(['password'=>$password]);
            if($result->status){
                // DB::table('password_resets')->where('token',$token)->delete();
                $response['message'] = trans('messages.password_changed');
                $response['delayTime'] = 5000;
                $response['url'] = url('/login');
                return response($this->getSuccessResponse($response));
            }else{
                return response($this->getErrorResponse(trans('messages.error')));    
            }
        }catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
        $this->print($request->all());
    }
    
}
