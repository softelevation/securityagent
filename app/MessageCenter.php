<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageCenter extends Model
{
    protected $collection = 'message_centers';
	
	protected $fillable = [
        'user_id','operator_id','message','message_type','status'
	];
}
