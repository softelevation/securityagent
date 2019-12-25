<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agents';

    public function user(){
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function types(){
    	return $this->hasMany('App\AgentType', 'agent_id');
    }

    public function diploma_certificates(){
    	return $this->hasMany('App\AgentDiplomaCertificate', 'user_id', 'user_id');
    }
}
