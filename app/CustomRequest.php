<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomRequest extends Model
{
    protected $table = 'custom_requests';
	protected $fillable = [
        'customer_id','title','location','latitude','longitude','intervention','agent_type',
		'total_hours','quick_book','start_date_time','vehicle_required','description','status'
	];
}
