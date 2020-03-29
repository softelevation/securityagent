<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentApproval extends Model
{
    protected $table = 'payment_approvals';

    public function mission_details(){
        return $this->hasOne('App\Mission', 'id', 'mission_id');
    }

    public function customer_details(){
        return $this->hasOne('App\Customer', 'id', 'customer_id');
    }
}
