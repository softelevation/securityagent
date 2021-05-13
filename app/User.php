<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function customer_info(){
        return $this->hasOne('App\Customer', 'user_id');
    }

    public function agent_info(){
        return $this->hasOne('App\Agent', 'user_id');
    }

    public function operator_info(){
        return $this->hasOne('App\Operator', 'user_id');
    }
	
	public function getProfileAttribute(){
		if(Session::has('userProfile')){
			return Session::get('userProfile');
		}else{
			return array();
		}
	}
	
	public function getTokenAttribute(){
		if(Session::has('accessToken')){
			return Session::get('accessToken');
		}else{
			return "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6NCwiZW1haWwiOiJzb25pYWJhbmdhNzBAZ21haWwuY29tIiwicm9sZV9pZCI6MSwic3ViX2lkIjoyLCJpYXQiOjE2MTkwMTEzMDN9.Jn-vEYWEZEHmj9414fRsvqPscNQfQMPY9gNfcoETLJY";
		}
	}
}
