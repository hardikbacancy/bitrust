<?php

Route::get('/', function () {
    return view('home');
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
    Route::post('/loan_request/loanStatusUpdate', 'LoanRequestController@loanStatusUpdate');
    Route::get('loan_request/loandetails/{requestId}', 'LoanRequestController@loanDetails');
    Route::resource('loan_request', 'LoanRequestController');

    Route::resource('users', 'UsersController')->middleware('Role:Superadmin|Admin');
    Route::get('profileedit/{id}', 'ProfileController@edit');
    Route::put('profileupdate/{id}', 'ProfileController@update');

    /* Admin settings */
    Route::get('/adminsettings', 'admin\AdminSettingController@index')->name('adminsettings.index');
    Route::get('/adminsettings/{id}/edit', 'admin\AdminSettingController@edit')->name('adminsettings.edit');
    Route::put('/adminsettings/{id}', 'admin\AdminSettingController@update')->name('adminsettings.update');
    Route::delete('/adminsettings/{id}', 'admin\AdminSettingController@destroy')->name('adminsettings.destroy');
});
