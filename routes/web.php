<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::get('/contact-us', function () {
    return view('contact');
});
Route::get('/register-agent-view','AgentController@index');
Route::post('/register_agent', 'AgentController@signup');
Route::get('/customer-signup', 'CustomerController@customerSignupView');
Route::post('/register_customer_form', 'CustomerController@customerSignupForm');
Route::get('/available-agents', 'AgentController@showAvailableAgents');
Route::get('/login', 'Auth\LoginController@loginView');
Route::post('/login', 'Auth\LoginController@allInOneLogin');

// Operator Routes
Route::group(['prefix'=>'operator'], function () {
    Route::group(['middleware'=>['auth','roles']], function () {
	    Route::get('/profile', 'OperatorController@loadProfileView');
	    Route::get('/agents/pending', 'OperatorController@loadPendingAgentsView');
        Route::get('/agents/pending/view/{id}', 'OperatorController@viewPendingAgentDetails');
        Route::post('/agent_verification', 'OperatorController@agentVerificationAction');
        Route::get('/customers/pending', 'OperatorController@loadPendingCustomerView');
        Route::get('/customers/pending/view/{id}', 'OperatorController@viewPendingCustomerDetails');
        Route::post('/customer_verification', 'OperatorController@customerVerificationAction');
        Route::get('/missions', 'OperatorController@missionsList');
        Route::get('/verify-mission/{id}', 'OperatorController@verifyMission');
    });
});

// Customer Routes
Route::group(['prefix'=>'customer'], function () {
    Route::group(['middleware'=>['auth','roles']], function () {
        Route::get('/profile', 'CustomerController@customerProfileView');
        Route::get('/missions', 'Customer\MissionController@index');
        Route::get('/create-mission', 'Customer\MissionController@createMission');
        Route::post('/save-mission', 'Customer\MissionController@saveMission');
    });
});


Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});
// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
