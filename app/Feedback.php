<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
	protected $fillable = [
        'customer_id','agent_id','mission_id','rating','message','status'
	];
	
	public function customer_details(){
    	return $this->hasOne('App\Customer', 'user_id', 'customer_id');
    }
	
	public function agent_details(){
    	return $this->hasOne('App\Agent', 'id', 'agent_id');
    }
}
