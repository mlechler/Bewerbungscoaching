<?php

Auth::routes();

Route::get('auth/logout', 'Auth\LoginController@logout');

Route::get('admin', ['as' => 'backend.dashboard', 'uses' => 'Backend\DashboardController@index']);

Route::get('admin/employees/{employee}/confirm', ['as' => 'backend.employees.confirm', 'uses' => 'Backend\EmployeesController@confirm']);
Route::resource('admin/employees', 'Backend\EmployeesController');

Route::get('admin/members/{member}/confirm', ['as' => 'backend.members.confirm', 'uses' => 'Backend\MembersController@confirm']);
Route::resource('admin/members', 'Backend\MembersController');

Route::get('admin/seminars/{seminar}/confirm', ['as' => 'backend.seminars.confirm', 'uses' => 'Backend\SeminarsController@confirm']);
Route::resource('admin/seminars', 'Backend\SeminarsController');

Route::get('admin/pages/{page}/confirm', ['as' => 'backend.pages.confirm', 'uses' => 'Backend\PagesController@confirm']);
Route::resource('admin/pages', 'Backend\PagesController');

Route::get('admin/blog/{blog}/confirm', ['as' => 'backend.blog.confirm', 'uses' => 'Backend\BlogController@confirm']);
Route::resource('admin/blog', 'Backend\BlogController');


Route::get('/', function () {
    return view('welcome');
});
