<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function login(){
    	return view('operator-login');
    }
}
