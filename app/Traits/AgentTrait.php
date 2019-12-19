<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Agent;
use App\Traits\HelperTrait;
use App\Traits\ResponseTrait;
use App\AgentDiplomaCertificate;

trait AgentTrait
{
    use HelperTrait;

    /**
    * Save agent data to database
    */

    public function registerAgent($request){
    	$post = array_except($request->all(),['_token']);
        $password = $this->generateToken(8);
    	$post['password'] = Hash::make($password);
    	$post['avatar_icon'] = 'dummy_avatar.jpg';
    	$username = 'agent'.mt_rand(10000, 99999);
    	$post['username'] = $username;

    	// Upload ID Proof Image
    	$icard = $request->file('identity_card');   
        $fileName = $username.'_id_'.time().'.'.$icard->getClientOriginalExtension();
        $filePath = public_path('agent/documents');
        $uploadStatus = $icard->move($filePath,$fileName);
        $post['identity_card'] = $fileName;

        // Upload Social Security Number Proof
        $scn = $request->file('social_security_number');   
        $fileName = $username.'_ssn_'.time().'.'.$scn->getClientOriginalExtension();
        $filePath = public_path('agent/documents');
        $uploadStatus = $scn->move($filePath,$fileName);
        $post['social_security_number'] = $fileName;
        
        // Upload Agent CV
        $cv = $request->file('cv');   
        $fileName = $username.'_cv_'.time().'.'.$cv->getClientOriginalExtension();
        $filePath = public_path('agent/documents');
        $uploadStatus = $cv->move($filePath,$fileName);
        $post['cv'] = $fileName;

        $post['status'] = 0;
        $post['work_location_lat_long'] = $post['work_location']['lat'].', '.$post['work_location']['long'];
        $post['current_location_lat_long'] = $post['current_location']['lat'].', '.$post['current_location']['long'];
        $post['created_at'] = Carbon::now();
        $post['updated_at'] = Carbon::now();
		//Save Data to Database 
        $certificates = $request->diploma;
        unset($post['work_location'],$post['current_location'],$post['diploma']);
        $agentID = Agent::insertGetId($post);
        if($agentID){
            //Add diploma certificates
            if($post['agent_type']==1 || $post['agent_type']==2 || $post['agent_type']==3){
                if(isset($certificates) && !empty($certificates)){
                    $i=0;
                    foreach($certificates as $certificate) {
                        $fileName = $username.'_dip_'.time().'.'.$certificate->getClientOriginalExtension();
                        $filePath = public_path('agent/documents');
                        $uploadStatus = $certificate->move($filePath,$fileName);
                        $data = [
                            'user_id' => $agentID,
                            'file_name' => $fileName,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];
                        AgentDiplomaCertificate::insert($data);
                        $i++;
                    }
                }
            }
        }
        if($agentID){
            $response['message'] = 'Agent has been registered successfully. You will receive an email for your login credentials.';
            $response['delayTime'] = 5000;
            $response['url'] = url('/');
            return $this->getSuccessResponse($response);
        }else{
            return $this->getErrorResponse('Something went wrong !');
        }
       
    }

    /**
    * Get available agents from database
    */
    public function getAvailableAgents(){
        $agents = Agent::select('username','avatar_icon','agent_type','work_location_lat_long')->get();
        $agentArr = [];
        foreach($agents as $agent){
            $strArr   = [];
            $strArr[] = $agent->username;
            $strArr[] = asset('avatars/'.$agent->avatar_icon);
            $strArr[] = $agent->agent_type;
            $latlong  = explode(",", $agent->work_location_lat_long);
            $strArr[] = trim($latlong[0]);
            $strArr[] = trim($latlong[1]);
            $agentArr[] = $strArr; 
        }
        return $agentArr;
    }
}
