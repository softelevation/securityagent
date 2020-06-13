<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPaymentHistory extends Model
{
    protected $table = 'user_payment_histories';

    public function mission_details(){
        return $this->hasOne('App\Mission', 'id', 'mission_id');
    }

    public function customer_details(){
        return $this->hasOne('App\Customer', 'id', 'customer_id');
    }

}
