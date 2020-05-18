<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionRequestsIgnored extends Model
{
    protected $table = 'mission_requests_ignoreds';

    public function mission_details(){
        return $this->hasOne('App\Mission', 'id', 'mission_id');
    }

    public function agent_details(){
        return $this->hasOne('App\Agent', 'id', 'agent_id');
    }
}
