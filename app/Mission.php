<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mission extends Model
{
    protected $table = 'missions';

    public function customer_details(){
    	return $this->belongsTo('App\Customer', 'customer_id', 'id');
    }
	
	public function upload_invoice(){
    	return $this->belongsTo('App\UploadInvoice', 'id', 'mission_id');
    }

    public function agent_details(){
    	return $this->hasOne('App\Agent', 'id', 'agent_id');
    }

    public function payments(){
    	return $this->hasMany('App\UserPaymentHistory', 'mission_id');
    }

    public function child_missions(){
        return $this->hasMany('App\Mission', 'parent_id');
    }

    static function save_agent_info($array){
        try {
            $get_type =  DB::table('agent_info')->where('type',$array['type'])->orderByDesc('id')->first();
           
            if($get_type){
                DB::table('agent_info')
                ->where('type',$array['type'])
                ->update($array);  
            }else{
                $get =  DB::table('agent_info')->insert( $array );
            }
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            dd($ex->getMessage()); 
        }
    } 

    static function get_agent_info($type){
        try { 
            if($type == 3){
                $get =  DB::table('agent_info')->where('status',1)->orderByDesc('id')->get();
            }else{
                $get =  DB::table('agent_info')->where('status',1)->where('type',$type)->orderByDesc('id')->get();
            }
        } catch(\Illuminate\Database\QueryException $ex){ 
            dd($ex->getMessage()); 
        }
        return $get;
    }
} 
