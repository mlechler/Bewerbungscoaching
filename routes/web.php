<?php

Auth::routes();

Route::get('auth/logout', 'Auth\LoginController@logout');

Route::get('admin', ['as' => 'backend.dashboard', 'uses' => 'Backend\DashboardController@index']);

Route::resource('admin/members', 'Backend\MembersController');

Route::get('admin/employees/{id}/confirm', ['as' => 'backend.employees.confirm', 'uses' => 'Backend\EmployeesController@confirm']);
Route::get('admin/employees/{id}/edit', ['as' => 'backend.employees.edit', 'uses' => 'Backend\EmployeesController@edit']);
Route::resource('admin/employees', 'Backend\EmployeesController');




Route::get('/', function () {
    return view('welcome');
});
