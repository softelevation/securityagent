<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Agent;

trait AgentTrait
{
    public function registerAgent($request){
    	$post = array_except($request->all(),['_token','password_confirmation']);
    	$post['password'] = Hash::make($post['password']);
    	$post['avatar_icon'] = public_path('avatars/dummy_avatar.jpg');
    	$username = 'agent'.mt_rand(10000, 99999);
    	$post['username'] = $username;
    	// Upload ID Proof Image
    	$id_proof = $request->file('id_proof');   
        $fileName = $username.'_id_'.time().'.'.$id_proof->getClientOriginalExtension();
        $filePath = public_path('agent/documents');
        $uploadStatus = $id_proof->move($filePath,$fileName);
        // Upload Agent Number Proof Image
        $agent_proof = $request->file('agent_number_proof');   
        $fileName = $username.'_no_'.time().'.'.$agent_proof->getClientOriginalExtension();
        $filePath = public_path('agent/documents');
        $uploadStatus = $agent_proof->move($filePath,$fileName);
        $post['status'] = 0;
        $post['created_at'] = Carbon::now();
        $post['updated_at'] = Carbon::now();
		//Save Data to Database 
        Agent::insert($post);
    }
}
