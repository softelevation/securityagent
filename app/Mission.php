<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $table = 'missions';

    public function customer_details(){
    	return $this->belongsTo('App\Customer', 'customer_id', 'id');
    }

    public function agent_details(){
    	return $this->hasOne('App\Agent', 'id', 'agent_id');
    }

    public function payments(){
    	return $this->hasMany('App\UserPaymentHistory', 'mission_id');
    }

    public function child_missions(){
        return $this->hasMany('App\Mission', 'parent_id');
    }
}
