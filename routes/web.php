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
    Route::post('/logout', 'MemberAuth\LoginController@logout');

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
    Route::resource('/employees', 'Backend\EmployeesController');

    Route::get('/members/{member}/confirm', ['as' => 'backend.members.confirm', 'uses' => 'Backend\MembersController@confirm']);
    Route::resource('/members', 'Backend\MembersController');

    Route::get('/seminars/{seminar}/confirm', ['as' => 'backend.seminars.confirm', 'uses' => 'Backend\SeminarsController@confirm']);
    Route::resource('/seminars', 'Backend\SeminarsController');

    Route::get('/pages/{page}/confirm', ['as' => 'backend.pages.confirm', 'uses' => 'Backend\PagesController@confirm']);
    Route::resource('/pages', 'Backend\PagesController');

    Route::get('/blog/{blog}/confirm', ['as' => 'backend.blog.confirm', 'uses' => 'Backend\BlogController@confirm']);
    Route::resource('/blog', 'Backend\BlogController');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
  return view('home');
});