<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadInvoice extends Model
{
	protected $table = 'upload_invoices';
	protected $fillable = [
        'user_id','mission_id','invoice','status'
	];
	
    public function user(){
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
