<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/home', 'HomeController@index')->name('home');
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'ApiController@login');
    Route::post('signup', 'ApiController@signup');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'ApiController@logout');
        Route::get('user', 'ApiController@user');
    });
});


Route::group(['namespace' => 'Api'], function(){
	Route::get('home', 'ApiController@myuserdata');
});













