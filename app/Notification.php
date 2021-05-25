<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    // public function mission_details(){
        // return $this->hasOne('App\Mission', 'id', 'mission_id');
    // }

    // public function customer_details(){
        // return $this->hasOne('App\Customer', 'id', 'customer_id');
    // }
}
