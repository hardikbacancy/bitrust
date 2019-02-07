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

    Route::get('membership/membershipDetails/{Id}', 'admin\MembershipController@membershipDetails')->name('membership.membership_details');
    Route::post('membership/membershipDetailsAjax', 'admin\MembershipController@membershipDetailsPostAjax')->name('membership.membershipDetailsPostAjax');
    Route::get('membership/membershipDetails/view/{Id}', 'admin\MembershipController@viewMembership')->name('membership.view');
});


Route::group(['prefix' => ADMIN, 'as' => ADMIN . '.', 'middleware'=>['auth','Role:Superadmin|Admin']], function() {
	/* Admin settings */
    Route::get('/adminsettings', 'admin\AdminSettingController@index')->name('adminsettings.index');
    Route::get('/adminsettings/{id}/edit', 'admin\AdminSettingController@edit')->name('adminsettings.edit');
    Route::put('/adminsettings/{id}', 'admin\AdminSettingController@update')->name('adminsettings.update');
    // Route::delete('/adminsettings/{id}', 'admin\AdminSettingController@destroy')->name('adminsettings.destroy');
    Route::get('report', 'admin\ReportController@report')->name('report.report');
    Route::post('report','admin\ReportController@report')->name('report.reportPost');

//    Route::get('report', 'admin\ReportController@report')->name('report.report');
//    Route::post('report','admin\ReportController@report')->name('report.report');

    Route::post('report-list-ajax','admin\ReportController@reportList')->name('report.reportPostAjax');
    Route::post('checkData','admin\ReportController@checkData')->name('checkData');

    Route::post('statusPenalty','admin\StatusPenaltyController@statusPenalty')->name('statusPenalty');
    Route::resource('non_loan_users', 'NonLoanUserController');
    Route::post('/loan_request/loanStatusUpdate', 'LoanRequestController@loanStatusUpdate')->name('loanStatusUpdate');
    Route::post('/deleteEmi', 'LoanRequestController@deleteEmi')->name('deleteEmi');

    //Membership
    Route::get('membership', 'admin\MembershipController@membership')->name('membership');
    Route::get('membership/create/{Id}', 'admin\MembershipController@membershipCreate')->name('membership.create');
    Route::post('membership/store', 'admin\MembershipController@store')->name('membership.store');
    Route::post('membership/membershipPostAjax', 'admin\MembershipController@membershipPostAjax')->name('membership.membershipPostAjax');
    Route::get('membership/membershipDetails/edit/{Id}', 'admin\MembershipController@editMembership')->name('membership.edit');
    Route::post('membership-update', 'admin\MembershipController@updateMembership')->name('update-membership');
    Route::post('membership-delete', 'admin\MembershipController@deleteMember')->name('membership.deleteMemberAjax');
    Route::get('import', 'admin\ImportController@import')->name('import');
    Route::post('importMembership', 'admin\ImportController@importMembership')->name('membership.importMembership');

    //Expense
    Route::get('expense', 'admin\ExpenseController@expense')->name('expense');
    Route::post('expense/expensePostAjax', 'admin\ExpenseController@expensePostAjax')->name('expense.expensePostAjax');
    Route::get('expense/create', 'admin\ExpenseController@expenseCreate')->name('expense.create');
    Route::post('expense/store', 'admin\ExpenseController@store')->name('expense.store');
    Route::get('expense/edit/{Id}', 'admin\ExpenseController@editExpense')->name('expense.edit');
    Route::post('expense/update', 'admin\ExpenseController@updateExpense')->name('expense.update');







});