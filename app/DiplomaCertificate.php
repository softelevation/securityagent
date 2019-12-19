<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiplomaCertificate extends Model
{
     public function Agents(){
    	return $this->belongsToMany('App\Agent', 'id','user_id');
    }
}
