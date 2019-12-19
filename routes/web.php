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
Route::get('/available-agents', 'AgentController@showAvailableAgents');

Route::prefix('operator')->group(function () {
    Route::get('/login', 'OperatorController@login');
    Route::post('/operator_login', 'OperatorController@operatorLogin');
    Route::get('/dashboard', 'OperatorController@loadDashboardView');
    Route::get('/agents/pending', 'OperatorController@loadPendingAgentsView');
});
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
