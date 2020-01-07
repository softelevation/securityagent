<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $table = 'missions';

    public function customer_details(){
    	return $this->belongsTo('App\Customer', 'customer_id', 'id');
    }
}
