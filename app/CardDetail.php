<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardDetail extends Model
{
    protected $table = 'card_details';
	protected $fillable = [
        'user_id','name','card_number','expire_month','expire_year'
	];
}
