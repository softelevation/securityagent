<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agents';
    public function Certificates(){
    	return $this->hasMany('App\DiplomaCertificate', 'user_id', 'id');
    }
}
