<?php

Route::group(['prefix' => 'employee'], function () {
    Route::get('/login', 'EmployeeAuth\LoginController@showLoginForm');
    Route::post('/login', 'EmployeeAuth\LoginController@login');
    Route::get('/logout', 'EmployeeAuth\LoginController@logout');

    Route::post('/password/email', 'EmployeeAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'EmployeeAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'EmployeeAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'EmployeeAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'member'], function () {
    Route::get('/login', 'MemberAuth\LoginController@showLoginForm');
    Route::post('/login', 'MemberAuth\LoginController@login');
    Route::get('/logout', 'MemberAuth\LoginController@logout');

    Route::get('/register', 'MemberAuth\RegisterController@showRegistrationForm');
    Route::post('/register', 'MemberAuth\RegisterController@register');

    Route::post('/password/email', 'MemberAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'MemberAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'MemberAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'MemberAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'backend'], function () {
    Route::get('/', ['as' => 'backend.dashboard', 'uses' => 'Backend\DashboardController@index']);

    Route::get('/employees/{employee}/confirm', ['as' => 'backend.employees.confirm', 'uses' => 'Backend\EmployeesController@confirm']);
    Route::get('/employees/{employee}/detail', ['as' => 'backend.employees.detail', 'uses' => 'Backend\EmployeesController@detail']);
    Route::get('/employees/files/{file}/delete', 'Backend\EmployeesController@deleteFile');
    Route::resource('/employees', 'Backend\EmployeesController');

    Route::get('/members/{member}/confirm', ['as' => 'backend.members.confirm', 'uses' => 'Backend\MembersController@confirm']);
    Route::get('/members/{member}/detail', ['as' => 'backend.members.detail', 'uses' => 'Backend\MembersController@detail']);
    Route::post('/members/{member}/uploadCheckedFile', ['as' => 'backend.members.uploadCheckedFile', 'uses' => 'Backend\MembersController@uploadCheckedFiles']);
    Route::get('/members/files/{file}/delete', 'Backend\MembersController@deleteFile');
    Route::resource('/members', 'Backend\MembersController');

    Route::get('/seminars/{seminar}/confirm', ['as' => 'backend.seminars.confirm', 'uses' => 'Backend\SeminarsController@confirm']);
    Route::get('/seminars/{seminar}/detail', ['as' => 'backend.seminars.detail', 'uses' => 'Backend\SeminarsController@detail']);
    Route::get('/seminars/files/{file}/delete', 'Backend\SeminarsController@deleteFile');
    Route::resource('/seminars', 'Backend\SeminarsController');

    Route::get('/seminarappointments/{seminarappointment}/confirm', ['as' => 'backend.seminars.confirm', 'uses' => 'Backend\AppointmentsController@confirm']);
    Route::get('/seminarappointments/{seminarappointment}/detail', ['as' => 'backend.seminars.detail', 'uses' => 'Backend\AppointmentsController@detail']);
    Route::get('/seminarappointments/{seminarappointment}/removeParticipant/{participant}', 'Backend\AppointmentsController@removeParticipant');
    Route::resource('/seminarappointments', 'Backend\AppointmentsController');

    Route::get('/pages/{page}/confirm', ['as' => 'backend.pages.confirm', 'uses' => 'Backend\PagesController@confirm']);
    Route::get('/pages/{page}/detail', ['as' => 'backend.pages.detail', 'uses' => 'Backend\PagesController@detail']);
    Route::resource('/pages', 'Backend\PagesController');

    Route::get('/blog/{blog}/confirm', ['as' => 'backend.blog.confirm', 'uses' => 'Backend\BlogController@confirm']);
    Route::get('/blog/{blog}/detail', ['as' => 'backend.blog.detail', 'uses' => 'Backend\BlogController@detail']);
    Route::resource('/blog', 'Backend\BlogController');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
  return view('home');
});