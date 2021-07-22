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
Route::get('/suport-ticket', function () {
    return view('suportTicket');
});
// Route::get('/agent_information', function () {
//     return view('agent_information');
// });

Route::any('/agent_information', 'OperatorController@agent_information');
Route::any('/privacy-policy', 'OperatorController@privacyPolicy');
Route::any('/legal-notice', 'OperatorController@legalNotice');
Route::any('/general-terms-and-conditions', 'OperatorController@generalTermsAndConditions');
Route::any('/general-terms-of-use', 'OperatorController@generalTermsOfUse');

Route::get('/testing', 'CustomerController@testing');


Route::get('/terms-conditions', function () {
    return view('terms_conditions');
});
Route::get('/reset-password', function () {
    return view('reset_password');
});

// Cron Jobs
Route::get('/mission-expired-cron', 'CommonController@missionExpiredCronJob');
 

Route::get('/reset-password-request/{token}', 'UserController@ChangePasswordView');
Route::post('/set_new_password', 'UserController@SetNewPassword');
Route::post('/reset-password', 'UserController@ResetPasswordRequest');
Route::get('/refresh-captcha', 'CommonController@refreshCaptcha');
Route::get('/change-language/{lang}', 'CommonController@changeLanguage');
Route::post('/contact-form-submission', 'CommonController@submitContactForm');
Route::post('/suport-ticket', 'CommonController@suportTicket');
Route::get('/register-agent-view','AgentController@index');
Route::post('/agent-file', 'AgentController@agentFile');
Route::post('/register_agent', 'AgentController@signup');
Route::get('/customer-signup', 'CustomerController@customerSignupView');
Route::post('/register_customer_form', 'CustomerController@customerSignupForm');
Route::get('/available-agents', 'AgentController@showAvailableAgents')->name('available-agents');
Route::get('/available-agents-security-patrol', 'AgentController@showAvailableAgentSecurityPatrol')->name('available-agents-security-patrol');
Route::get('/login', 'Auth\LoginController@loginView');
Route::post('/login', 'Auth\LoginController@allInOneLogin')->name('login');
Route::post('/save-mission-temporary', 'Customer\MissionController@saveMissionTemp');
Route::post('/book-agent', 'Customer\MissionController@bookAgent');
Route::get('/agent-details/{agent_id}/{distance}', 'AgentController@viewAgentDetails');
Route::post('/process-notification', 'CustomerController@processNotifications');
Route::post('/update-profile', 'UserController@updateProfileDetails');
Route::post('/update-password', 'UserController@updatePassword');
Route::post('/upload-media', 'UserController@uploadMedia');
Route::get('/download-payment-receipt/{payment_id}', 'UserController@downloadPaymentReceipt');


// Operator Routes
Route::group(['prefix'=>'operator'], function () {
    Route::group(['middleware'=>['auth','roles']], function () {
	    Route::get('/profile', 'OperatorController@loadProfileView');
        Route::get('/agents', 'OperatorController@viewAgentsList');
        Route::get('/report', 'OperatorController@reportFilter');
        Route::post('/report', 'OperatorController@reportFilterPost');
		
		Route::get('/report/{mission_id}', 'OperatorController@reportPdf');
		Route::get('/report-view/{mission_id}', 'OperatorController@reportView');
        Route::get('/agent/view/{id}', 'OperatorController@viewAgentDetails');
        Route::get('/agent/delete/{id}', 'OperatorController@deleteAgentDetails');
        
        Route::post('/agent_verification', 'OperatorController@agentVerificationAction');
        Route::get('/customers', 'OperatorController@viewCustomersList');
        Route::get('/customer_status', 'OperatorController@customer_status');
        Route::get('/customer/view/{id}', 'OperatorController@viewCustomerDetails');
        Route::get('/customer/delete/{id}', 'OperatorController@deleteCustomerDetails');

        Route::post('/customer_verification', 'OperatorController@customerVerificationAction');
        Route::get('/missions', 'OperatorController@missionsList');
		Route::get('/mission-requests', 'OperatorController@missionRequest');
		Route::get('/mission-requests/view/{mission_id}', 'OperatorController@viewMissionRequestDetails');
		Route::post('/custom-request-amount-cal', 'OperatorController@customRequestAmountCal');
		Route::post('/sand-custom-request/{mission_id}', 'OperatorController@sandCustomRequest');
		Route::get('/custom-request-assign-agent/{mission_id}', 'OperatorController@customRequestAssignAgent');
        Route::get('/mission-details/view/{mission_id}', 'OperatorController@viewMissionDetails');
        Route::get('/assign-agent/{mission_id}', 'OperatorController@assignMissionAgent');
        Route::get('/sub-mission/{mission_id}', 'OperatorController@createSubMissions');
        Route::post('/book-agent-later-mission', 'OperatorController@bookAgentLaterMission');
        Route::get('/verify-mission/{id}', 'OperatorController@verifyMission');
        Route::get('/billing-details', 'OperatorController@getPaymentHistory');
        Route::get('/billing-detail-download/{id}', 'OperatorController@billingDetailDownload');
        Route::get('/payment-approvals', 'OperatorController@paymentApprovalsView');
        Route::post('/payment-approval-action', 'OperatorController@paymentApprovalAction');
        Route::get('/missions-without-agents', 'OperatorController@missionsListWithoutAgents');
        Route::get('/refund-requests', 'OperatorController@refundRequestsView');
        Route::get('/message-center', 'OperatorController@messageCenter');
		Route::get('/message-center/{id}', 'OperatorController@messageCenterId');
        Route::post('/message-center', 'OperatorController@messageCenterPost');
        Route::post('/process-refund-request', 'OperatorController@processRefundRequest');
        Route::get('/refund-mission-view/{mission_id}', 'OperatorController@viewMissionDetailsRefund');
        Route::post('/refund-mission-amount', 'OperatorController@refundMissionAmount');
        Route::post('/block-unblock-agent', 'OperatorController@blockUnblockAgent');
        Route::get('/mission_chage_status/{status}/{mission_id}', 'OperatorController@missionChageStatus');

        Route::any('/agent_information_edit', 'OperatorController@agent_information_edit');
        Route::any('/agent_information_edit_fr', 'OperatorController@agent_information_edit_fr');
        
    });
});

// Customer Routes
Route::group(['prefix'=>'customer'], function () {
    Route::group(['middleware'=>['auth','roles']], function () {
        Route::get('/profile', 'CustomerController@customerProfileView');
        Route::get('/missions', 'Customer\MissionController@index');
		Route::get('/mission-request-list', 'Customer\MissionController@missionRequestList');
		Route::get('/mission-requests/view/{mission_id}', 'Customer\MissionController@missionRequestFromId');
		Route::get('/report-view/{mission_id}', 'Customer\MissionController@reportView');
		Route::get('/feedback/{id}', 'Customer\MissionController@viewAgentDetails');
		Route::post('/feedback/{id}', 'Customer\MissionController@feedback');
        Route::get('/upload-invoice/{mission_id}', 'Customer\MissionController@uploadInvoice');
        Route::post('/upload-invoice', 'Customer\MissionController@uploadInvoicePost');
        Route::get('/create-mission', 'Customer\MissionController@createMission');
        Route::post('/save-mission', 'Customer\MissionController@saveMission');
        Route::get('/mission-request', 'Customer\MissionController@iHaveAcustomRequest');
        Route::post('/mission-request', 'Customer\MissionController@iHaveAcustomRequestPost');
        Route::get('/quick-create-mission', 'Customer\MissionController@quickCreateMission');
        Route::get('/quick_mission/edit/{mission_id}', 'Customer\MissionController@editQuickMission');
        Route::get('/find-mission-agent/{mission_id}', 'Customer\MissionController@findMissionAgent');
        Route::get('/proceed-payment/{mission_id}', 'Customer\MissionController@proceedToPayment');
        Route::get('/custom-proceed-payment/{mission_id}', 'Customer\MissionController@customProceedToPayment');
        Route::get('/card-delete/{card_id}', 'Customer\MissionController@cardDelete');
        Route::get('/save-pdf-proceed-payment/{mission_id}', 'Customer\MissionController@savePdfProceedToPayment');
        Route::post('/make-mission-payment', 'Customer\MissionController@makeMissionPayment');
        Route::get('/mission-details/view/{mission_id}', 'Customer\MissionController@viewMissionDetails');
        Route::get('/track-mission/{mission_id}', 'Customer\MissionController@trackMission');
        Route::post('/make-card-payment', 'Customer\MissionController@makeCardPayment');
        Route::get('/billing-details', 'CustomerController@getPaymentHistory');
        Route::get('/message-center', 'CustomerController@messageCenter');
		Route::post('/message-center', 'CustomerController@messageCenterPost');
		Route::get('/patrolling-mission', 'CustomerController@patrollingMission');
        Route::get('/cancel-mission/{mission_id}', 'Customer\MissionController@cancelMission');
        Route::get('/delete-mission/{mission_id}', 'Customer\MissionController@deleteMission');
    });
});

// Agent Routes
Route::group(['prefix'=>'agent'], function () {
    Route::group(['middleware'=>['auth','roles']], function () {
		Route::get('/report', 'AgentController@reportFilter');
        Route::post('/report', 'AgentController@reportFilterPost');
        Route::get('/report/{mission_id}', 'AgentController@report');
        Route::get('/report-view/{mission_id}', 'AgentController@reportView');
        Route::post('/report/{mission_id}', 'AgentController@reportUpdate');
        Route::post('/signature/{mission_id}', 'AgentController@signatureUpdate');
        Route::get('/profile', 'AgentController@agentProfileView');
        Route::get('/missions', 'Agent\MissionController@index');
		Route::get('/mission-to-start', 'Agent\MissionController@missiontoStart');
        Route::get('/mission-details/view/{mission_id}', 'Agent\MissionController@viewMissionDetails');
        Route::get('/custom-mission-details/view/{mission_id}', 'Agent\MissionController@customMissionDetails');
        Route::post('/start-mission', 'Agent\MissionController@startMission');
        Route::post('/finish-mission', 'Agent\MissionController@finishMission');
        Route::post('/set-availability', 'AgentController@setAvailability');
        Route::get('/mission-requests', 'Agent\MissionController@viewMissionRequests');
        Route::get('/message-center', 'Agent\MissionController@messageCenter');
		Route::post('/message-center', 'Agent\MissionController@messageCenterPost');
        Route::post('/process-mission-request', 'Agent\MissionController@processMissionRequest');
        Route::get('/schedule/{agent_id}', 'AgentController@setScheduleView');
        Route::post('save-schedule', 'AgentController@saveSchedule');
        Route::post('/create-sub-missions', 'AgentController@agentSubMissions');
        Route::post('/mission-expired', 'AgentController@missionExpiredRequest');
        Route::get('/remove-expired-mission/{mission_id}', 'AgentController@removeExpiredMission');
    });
});


Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});
// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
