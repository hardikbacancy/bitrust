<?php

Route::get('/', function () {
    //return view('home');
    return view('auth.login');
});

Route::get('login', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
Route::get('/user/verify/{verification_code}', 'Auth\VerificationController@verifyUser');

/*
|------------------------------------------------------------------------------------
| Admin
|------------------------------------------------------------------------------------
*/
Route::group(['prefix' => ADMIN, 'as' => ADMIN . '.', 'middleware'=>['auth']], function() {
    Route::get('/', ['uses'=>'DashboardController@index', 'as'=>'dash']);
    Route::get('loan_request/loandetails/{requestId}', 'LoanRequestController@loanDetails')->name('loan_request.loan_details');
    Route::resource('loan_request', 'LoanRequestController');
    Route::resource('users', 'UsersController')->middleware('Role:Superadmin|Admin');
    Route::get('profileedit/{id}', 'ProfileController@edit')->middleware('authcheck');
    Route::put('profileupdate/{id}', 'ProfileController@update')->middleware('authcheck');
});


Route::group(['prefix' => ADMIN, 'as' => ADMIN . '.', 'middleware'=>['auth','Role:Superadmin|Admin']], function() {
	/* Admin settings */
    Route::get('/adminsettings', 'admin\AdminSettingController@index')->name('adminsettings.index');
    Route::get('/adminsettings/{id}/edit', 'admin\AdminSettingController@edit')->name('adminsettings.edit');
    Route::put('/adminsettings/{id}', 'admin\AdminSettingController@update')->name('adminsettings.update');
    // Route::delete('/adminsettings/{id}', 'admin\AdminSettingController@destroy')->name('adminsettings.destroy');
    Route::get('report', 'admin\ReportController@report')->name('report.report');
    Route::post('report','admin\ReportController@report')->name('report.reportPost');
    Route::post('report-list-ajax','admin\ReportController@reportList')->name('report.reportPostAjax');
    Route::post('checkData','admin\ReportController@checkData')->name('checkData');

    Route::post('statusPenalty','admin\StatusPenaltyController@statusPenalty')->name('statusPenalty');
    Route::resource('non_loan_users', 'NonLoanUserController');
    Route::post('/loan_request/loanStatusUpdate', 'LoanRequestController@loanStatusUpdate')->name('loanStatusUpdate');
    Route::post('/deleteEmi', 'LoanRequestController@deleteEmi')->name('deleteEmi');
});