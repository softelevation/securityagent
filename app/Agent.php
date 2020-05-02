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

    public function schedule(){
        return $this->hasMany('App\AgentSchedule', 'agent_id');
    }

    public function missions(){
        return $this->hasMany('App\Mission', 'agent_id');
    }

    public function upcoming_mission(){
        return $this->hasOne('App\Mission', 'agent_id');
    }

    public function agent_ignored(){
        return $this->hasMany('App\MissionRequestsIgnored', 'agent_id');
    }
}
