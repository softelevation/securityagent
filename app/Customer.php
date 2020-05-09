<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $table = 'customers';
    public function user(){
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
