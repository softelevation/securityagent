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
Route::get('/agent_information', function () {
    return view('agent_information');
});

// Cron Jobs
Route::get('/mission-expired-cron', 'CommonController@missionExpiredCronJob');

Route::get('/register-agent-view','AgentController@index');
Route::post('/register_agent', 'AgentController@signup');
Route::get('/customer-signup', 'CustomerController@customerSignupView');
Route::post('/register_customer_form', 'CustomerController@customerSignupForm');
Route::get('/available-agents', 'AgentController@showAvailableAgents')->name('available-agents');
Route::get('/login', 'Auth\LoginController@loginView');
Route::post('/login', 'Auth\LoginController@allInOneLogin')->name('login');
Route::post('/save-mission-temporary', 'Customer\MissionController@saveMissionTemp');
Route::post('/book-agent', 'Customer\MissionController@bookAgent');
Route::get('/agent-details/{agent_id}', 'AgentController@viewAgentDetails');
Route::post('/process-notification', 'CustomerController@processNotifications');
Route::post('/update-profile', 'UserController@updateProfileDetails');
Route::post('/update-password', 'UserController@updatePassword');
Route::get('/download-payment-receipt/{payment_id}', 'UserController@downloadPaymentReceipt');


// Operator Routes
Route::group(['prefix'=>'operator'], function () {
    Route::group(['middleware'=>['auth','roles']], function () {
	    Route::get('/profile', 'OperatorController@loadProfileView');
        Route::get('/agents', 'OperatorController@viewAgentsList');
        Route::get('/agent/view/{id}', 'OperatorController@viewAgentDetails');
        Route::post('/agent_verification', 'OperatorController@agentVerificationAction');
        Route::get('/customers', 'OperatorController@viewCustomersList');
        Route::get('/customer/view/{id}', 'OperatorController@viewCustomerDetails');
        Route::post('/customer_verification', 'OperatorController@customerVerificationAction');
        Route::get('/missions', 'OperatorController@missionsList');
        Route::get('/mission-details/view/{mission_id}', 'OperatorController@viewMissionDetails');
        Route::get('/assign-agent/{mission_id}', 'OperatorController@assignMissionAgent');
        Route::get('/sub-mission/{mission_id}', 'OperatorController@createSubMissions');
        Route::post('/book-agent-later-mission', 'OperatorController@bookAgentLaterMission');
        Route::get('/verify-mission/{id}', 'OperatorController@verifyMission');
        Route::get('/billing-details', 'OperatorController@getPaymentHistory');
        Route::get('/payment-approvals', 'OperatorController@paymentApprovalsView');
        Route::post('/payment-approval-action', 'OperatorController@paymentApprovalAction');
        Route::get('/missions-without-agents', 'OperatorController@missionsListWithoutAgents');
        Route::get('/refund-requests', 'OperatorController@refundRequestsView');
        Route::post('/process-refund-request', 'OperatorController@processRefundRequest');
        Route::get('/refund-mission-view/{mission_id}', 'OperatorController@viewMissionDetailsRefund');
        Route::post('/refund-mission-amount', 'OperatorController@refundMissionAmount');
    });
});

// Customer Routes
Route::group(['prefix'=>'customer'], function () {
    Route::group(['middleware'=>['auth','roles']], function () {
        Route::get('/profile', 'CustomerController@customerProfileView');
        Route::get('/missions', 'Customer\MissionController@index');
        Route::get('/create-mission', 'Customer\MissionController@createMission');
        Route::post('/save-mission', 'Customer\MissionController@saveMission');
        Route::get('/quick-create-mission', 'Customer\MissionController@quickCreateMission');
        Route::get('/quick_mission/edit/{mission_id}', 'Customer\MissionController@editQuickMission');
        Route::get('/find-mission-agent/{mission_id}', 'Customer\MissionController@findMissionAgent');
        Route::get('/proceed-payment/{mission_id}', 'Customer\MissionController@proceedToPayment');
        Route::post('/make-mission-payment', 'Customer\MissionController@makeMissionPayment');
        Route::get('/mission-details/view/{mission_id}', 'Customer\MissionController@viewMissionDetails');
        Route::post('/make-card-payment', 'Customer\MissionController@makeCardPayment');
        Route::get('/billing-details', 'CustomerController@getPaymentHistory');
        Route::get('/cancel-mission/{mission_id}', 'Customer\MissionController@cancelMission');
        Route::get('/delete-mission/{mission_id}', 'Customer\MissionController@deleteMission');
    });
});

// Agent Routes
Route::group(['prefix'=>'agent'], function () {
    Route::group(['middleware'=>['auth','roles']], function () {
        Route::get('/profile', 'AgentController@agentProfileView');
        Route::get('/missions', 'Agent\MissionController@index');
        Route::get('/mission-details/view/{mission_id}', 'Agent\MissionController@viewMissionDetails');
        Route::post('/start-mission', 'Agent\MissionController@startMission');
        Route::post('/finish-mission', 'Agent\MissionController@finishMission');
        Route::post('/set-availability', 'AgentController@setAvailability');
        Route::get('/mission-requests', 'Agent\MissionController@viewMissionRequests');
        Route::post('/process-mission-request', 'Agent\MissionController@processMissionRequest');
        Route::get('/schedule/{agent_id}', 'AgentController@setScheduleView');
        Route::post('save-schedule', 'AgentController@saveSchedule');
        Route::post('/create-sub-missions', 'AgentController@agentSubMissions');
        Route::post('/mission-expired', 'AgentController@missionExpiredRequest');
    });
});


Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});
// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
