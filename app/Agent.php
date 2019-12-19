<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agents';

    public function user(){
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
