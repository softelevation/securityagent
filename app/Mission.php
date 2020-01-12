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
}
