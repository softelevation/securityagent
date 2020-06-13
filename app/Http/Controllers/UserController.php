<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validators\UserValidator;
use App\Traits\ResponseTrait;
use App\Customer;
use App\Operator;
use App\Agent;
use App\User;
use App\Helpers\Helper;
use App\UserPaymentHistory;
use App\Notifications\ResetPasswordNotification;
use Hash;
use Auth;
use DB;

class UserController extends Controller
{
	use UserValidator, ResponseTrait;


    /**
     * @param $request
     * @return mixed
     * @method updateProfileDetails
     * @purpose Update profile details
     */
    public function updateProfileDetails(Request $request){
        try{
            $post = array_except($request->all(),'_token');
            $validation = $this->updateProfileValidations($request);
            if($validation['status']==false){
                return response($this->getValidationsErrors($validation));
            }
            $role = \Auth::user()->role_id;
            $user_id = \Auth::user()->id;
            // Upload image
            if(isset($request->image) && $request->image!=""){
                $image = $request->file('image');   
                $fileName = time().'.'.$image->getClientOriginalExtension();
                $filePath = public_path('profile_images');
                $uploadStatus = $image->move($filePath,$fileName);
                $post['image'] = $fileName;
            }
            switch ($role) {
                case 1:
                    // Update customer table
                    $result = Customer::where('user_id',$user_id)->update($post);
                    $url = url('customer/profile'); 
                    break;
                case 2:
                    // Update customer table
                    $result = Agent::where('user_id',$user_id)->update($post);
                    $url = url('agent/profile'); 
                    break;
                case 3:
                    // Update customer table
                    $q = Operator::where('user_id',$user_id);
                    if($q->first()){
                        $result = $q->update($post);
                    }else{
                        $post['user_id'] = $user_id;
                        $result = $q->insert($post);
                    }
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
            if(Hash::check($current_password, Auth::user()->password)){
                $new_password = Hash::make($new_password);
                $result = User::where('id',Auth::id())->update(['password'=>$new_password]);
                if($result){
                    $response['message'] = trans('messages.password_changed');
                    $response['delayTime'] = 5000;
                    $response['url'] = url('/logout');
                    return response($this->getSuccessResponse($response));
                }
            }else{
                return response($this->getErrorResponse(trans('messages.wrong_current_password')));
            }
            
        }catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
    }

    public function downloadPaymentReceipt($id){
        $id = Helper::decrypt($id);
        $data = UserPaymentHistory::whereId($id)->first();
        $pdf = \PDF::loadView('pdf.payment_receipt', ['data'=>$data]);
        return $pdf->download('invoice.pdf');
        // return view('pdf.payment_receipt',['data'=>$data]);
    }

    public function ResetPasswordRequest(Request $request){
        $validation = $this->resetPasswordValidations($request);
        if($validation['status']==false){
            return response($this->getValidationsErrors($validation));
        }
        $email = $request->email;
        $user = User::where('email',$email)->first();
        if($user){
            $token = Helper::generateToken(30);
            $exists = DB::table('password_resets')->where('email',$email)->first();
            if($exists){
                $result = DB::table('password_resets')->where('email',$email)->update(['token'=>$token]);
            }else{
                $result = DB::table('password_resets')->insert(['email'=>$email,'token'=>$token]);
            }
            if($result){
                /*----Send Reset Password Link-----*/
                $mailContent = [
                    'name' => $user->first_name,
                    'url' => url('reset-password-request/'.$token) 
                ];
                $user->notify(new ResetPasswordNotification($mailContent));
                /*------------*/
                $response['message'] = trans('messages.reset_pwd_link_sent');
                $response['delayTime'] = 2000;
                return response($this->getSuccessResponse($response));
            }else{
                return response($this->getErrorResponse(trans('messages.error')));
            }
        }else{
            return response($this->getErrorResponse(trans('messages.email_not_exists')));
        }
    }

    public function ChangePasswordView($token){
        $data = DB::table('password_resets')->where('token',$token)->first();
        if($data){
            $param['token'] = $data->token;
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
            $token = $request->email_token;
            $data = DB::table('password_resets')->where('token',$token)->first();
            $email = $data->email;
            $password = Hash::make($request->password);
            $result = User::where('email',$email)->update(['password'=>$password]);
            if($result){
                DB::table('password_resets')->where('token',$token)->delete();
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
