<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validators\UserValidator;
use App\Traits\ResponseTrait;
use App\Customer;
use App\Operator;
use App\Agent;
use App\Helpers\Helper;
use App\UserPaymentHistory;
use Hash;
use Auth;

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
                $response['message'] = 'Profile details updated successfully.';
                $response['delayTime'] = 3000;
                $response['url'] = $url;
                return response($this->getSuccessResponse($response));
            }else{
                return response($this->getErrorResponse('Something went wrong!'));
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
                    $response['message'] = 'Your password changed successfully. You need to login again.';
                    $response['delayTime'] = 5000;
                    $response['url'] = url('/logout');
                    return response($this->getSuccessResponse($response));
                }
            }else{
                return response($this->getErrorResponse('The current password is wrong.'));
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
}
