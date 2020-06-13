<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    protected $table = 'refund_requests';

    public function mission_details(){
        return $this->hasOne('App\Mission', 'id', 'mission_id');
    }
}
