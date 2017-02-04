<?php

Route::group(['prefix' => 'employee'], function () {
    Route::get('/login', ['as' => 'employee.login', 'uses' => 'EmployeeAuth\LoginController@showLoginForm']);
    Route::post('/login', ['as' => 'employee.login', 'uses' => 'EmployeeAuth\LoginController@login']);
    Route::get('/logout', 'EmployeeAuth\LoginController@logout');

    Route::post('/password/email', 'EmployeeAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'EmployeeAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'EmployeeAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'EmployeeAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'member'], function () {
    Route::get('/login', ['as' => 'member.login', 'uses' => 'MemberAuth\LoginController@showLoginForm']);
    Route::post('/login', ['as' => 'member.login', 'uses' => 'MemberAuth\LoginController@login']);
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
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/employees/{employee}/confirm', ['as' => 'employees.confirm', 'uses' => 'Backend\EmployeesController@confirm']);
        Route::get('/employees/files/{file}/delete', ['as' => 'employees.deleteFile', 'uses' => 'Backend\EmployeesController@deleteFile']);
        Route::resource('/employees', 'Backend\EmployeesController');

        Route::get('/members/{member}/confirm', ['as' => 'members.confirm', 'uses' => 'Backend\MembersController@confirm']);
        Route::get('/members/files/{file}/delete', ['as' => 'members.deleteFile', 'uses' => 'Backend\MembersController@deleteFile']);
        Route::post('/members/delete', ['as' => 'members.deleteAllFiles', 'uses' => 'Backend\MembersController@deleteAllFiles']);
        Route::resource('/members', 'Backend\MembersController');

        Route::get('/seminars/{seminar}/confirm', ['as' => 'seminars.confirm', 'uses' => 'Backend\SeminarsController@confirm']);
        Route::get('/seminars/{seminar}/detail', ['as' => 'seminars.detail', 'uses' => 'Backend\SeminarsController@detail']);
        Route::get('/seminars/files/{file}/delete', ['as' => 'seminars.deleteFile', 'uses' => 'Backend\SeminarsController@deleteFile']);
        Route::resource('/seminars', 'Backend\SeminarsController');

        Route::get('/seminarappointments/{seminarappointment}/confirm', ['as' => 'seminarappointments.confirm', 'uses' => 'Backend\AppointmentsController@confirm']);
        Route::get('/seminarappointments/{seminarappointment}/removeparticipant/{participant}', ['as' => 'seminarappointments.removeParticipant', 'uses' => 'Backend\AppointmentsController@removeParticipant']);
        Route::resource('/seminarappointments', 'Backend\AppointmentsController');

        Route::get('/seminarbookings/{seminarbooking}/confirm', ['as' => 'seminarbookings.confirm', 'uses' => 'Backend\BookingsController@confirm']);
        Route::get('/seminarbookings/{seminarbooking}/detail', ['as' => 'seminarbookings.detail', 'uses' => 'Backend\BookingsController@detail']);
        Route::resource('/seminarbookings', 'Backend\BookingsController');

        Route::get('/individualcoachings/{individualcoaching}/confirm', ['as' => 'individualcoachings.confirm', 'uses' => 'Backend\IndividualCoachingsController@confirm']);
        Route::resource('/individualcoachings', 'Backend\IndividualCoachingsController');

        Route::get('/applicationpackages/{applicationpackage}/confirm', ['as' => 'applicationpackages.confirm', 'uses' => 'Backend\ApplicationPackagesController@confirm']);
        Route::resource('/applicationpackages', 'Backend\ApplicationPackagesController');

        Route::get('/packagepurchases/{packagepurchase}/confirm', ['as' => 'packagepurchases.confirm', 'uses' => 'Backend\PackagePurchasesController@confirm']);
        Route::get('/packagepurchases/files/{file}/delete', ['as' => 'packagepurchases.deleteFile', 'uses' => 'Backend\PackagePurchasesController@deleteFile']);
        Route::resource('/packagepurchases', 'Backend\PackagePurchasesController');

        Route::get('/applicationlayouts/{applicationlayout}/confirm', ['as' => 'applicationlayouts.confirm', 'uses' => 'Backend\ApplicationLayoutsController@confirm']);
        Route::get('/applicationlayouts/{applicationlayout}/detail', ['as' => 'applicationlayouts.detail', 'uses' => 'Backend\ApplicationLayoutsController@detail']);
        Route::get('/applicationlayouts/files/{file}/deletepreview', ['as' => 'applicationlayouts.deletePreview', 'uses' => 'Backend\ApplicationLayoutsController@deletePreviewFile']);
        Route::get('/applicationlayouts/files/{file}/deletelayout', ['as' => 'applicationlayouts.deleteLayout', 'uses' => 'Backend\ApplicationLayoutsController@deleteLayoutFile']);
        Route::resource('/applicationlayouts', 'Backend\ApplicationLayoutsController');

        Route::get('/layoutpurchases/{layoutpurchase}/confirm', ['as' => 'layoutpurchases.confirm', 'uses' => 'Backend\LayoutPurchasesController@confirm']);
        Route::get('/layoutpurchases/{layoutpurchase}/detail', ['as' => 'layoutpurchases.detail', 'uses' => 'Backend\LayoutPurchasesController@detail']);
        Route::resource('/layoutpurchases', 'Backend\LayoutPurchasesController');

        Route::get('/discounts/{discount}/confirm', ['as' => 'discounts.confirm', 'uses' => 'Backend\DiscountsController@confirm']);
        Route::get('/discounts/{discount}/detail', ['as' => 'discounts.detail', 'uses' => 'Backend\DiscountsController@detail']);
        Route::resource('/discounts', 'Backend\DiscountsController');

        Route::get('/memberdiscounts/{memberdiscount}/confirm', ['as' => 'memberdiscounts.confirm', 'uses' => 'Backend\MemberDiscountsController@confirm']);
        Route::get('/memberdiscounts/{memberdiscount}/detail', ['as' => 'memberdiscounts.detail', 'uses' => 'Backend\MemberDiscountsController@detail']);
        Route::resource('/memberdiscounts', 'Backend\MemberDiscountsController');

        Route::get('/invoices/{invoice}/confirm', ['as' => 'invoices.confirm', 'uses' => 'Backend\InvoicesController@confirm']);
        Route::get('/invoices/{invoice}/detail', ['as' => 'invoices.detail', 'uses' => 'Backend\InvoicesController@detail']);
        Route::resource('/invoices', 'Backend\InvoicesController');

        Route::get('/pages/{page}/confirm', ['as' => 'pages.confirm', 'uses' => 'Backend\PagesController@confirm']);
        Route::get('/pages/{page}/detail', ['as' => 'pages.detail', 'uses' => 'Backend\PagesController@detail']);
        Route::resource('/pages', 'Backend\PagesController');

        Route::get('/blog/{blog}/confirm', ['as' => 'blog.confirm', 'uses' => 'Backend\BlogController@confirm']);
        Route::resource('/blog', 'Backend\BlogController');

        Route::get('/todo/{todo}/confirm', ['as' => 'todo.confirm', 'uses' => 'Backend\TasksController@confirm']);
        Route::post('/todo/delete', ['as' => 'todo.deleteAllFinishedTasks', 'uses' => 'Backend\TasksController@deleteAllFinishedTasks']);
        Route::resource('/todo', 'Backend\TasksController');
    });
    Route::get('/employees/{employee}/detail', ['as' => 'employees.detail', 'uses' => 'Backend\EmployeesController@detail']);
    Route::resource('/employees', 'Backend\EmployeesController', ['only' => ['edit', 'update']]);

    Route::get('/employeefreetimes/{employeefreetime}/confirm', ['as' => 'employeefreetimes.confirm', 'uses' => 'Backend\EmployeeFreeTimesController@confirm']);
    Route::get('/employeefreetimes/{employeefreetime}/detail', ['as' => 'employeefreetimes.detail', 'uses' => 'Backend\EmployeeFreeTimesController@detail']);
    Route::resource('/employeefreetimes', 'Backend\EmployeeFreeTimesController');

    Route::get('/members/{member}/detail', ['as' => 'members.detail', 'uses' => 'Backend\MembersController@detail']);
    Route::post('/members/{member}/uploadcheckedfile', ['as' => 'members.uploadCheckedFile', 'uses' => 'Backend\MembersController@uploadCheckedFiles']);
    Route::resource('/members', 'Backend\MembersController', ['only' => ['index']]);

    Route::get('/seminars/{seminar}/detail', ['as' => 'seminars.detail', 'uses' => 'Backend\SeminarsController@detail']);
    Route::get('/seminars/files/{file}/delete', ['as' => 'seminars.deleteFile', 'uses' => 'Backend\SeminarsController@deleteFile']);
    Route::resource('/seminars', 'Backend\SeminarsController', ['only' => ['index']]);

    Route::get('/seminarappointments/{seminarappointment}/detail', ['as' => 'seminarappointments.detail', 'uses' => 'Backend\AppointmentsController@detail']);
    Route::resource('/seminarappointments', 'Backend\AppointmentsController', ['only' => ['index']]);

    Route::get('/individualcoachings/{individualcoaching}/detail', ['as' => 'individualcoachings.detail', 'uses' => 'Backend\IndividualCoachingsController@detail']);
    Route::resource('/individualcoachings', 'Backend\IndividualCoachingsController', ['only' => ['index', 'create', 'store', 'edit', 'update']]);

    Route::get('/applicationpackages/{applicationpackage}/detail', ['as' => 'applicationpackages.detail', 'uses' => 'Backend\ApplicationPackagesController@detail']);
    Route::resource('/applicationpackages', 'Backend\ApplicationPackagesController', ['only' => ['index']]);

    Route::get('/packagepurchases/{packagepurchase}/detail', ['as' => 'packagepurchases.detail', 'uses' => 'Backend\PackagePurchasesController@detail']);
    Route::post('/packagepurchases/{packagepurchase}/uploadpackagefile', ['as' => 'packagepurchases.uploadPackageFile', 'uses' => 'Backend\PackagePurchasesController@uploadPackageFile']);

    Route::get('/blog/{blog}/detail', ['as' => 'blog.detail', 'uses' => 'Backend\BlogController@detail']);
    Route::resource('/blog', 'Backend\BlogController', ['only' => ['index', 'create', 'store', 'edit', 'update']]);

    Route::get('/todo/{todo}/detail', ['as' => 'todo.detail', 'uses' => 'Backend\TasksController@detail']);
    Route::get('/todo/{todo}/finished', ['as' => 'todo.finishedTask', 'uses' => 'Backend\TasksController@taskFinished']);
    Route::resource('/todo', 'Backend\TasksController', ['only' => ['index', 'create', 'store', 'edit', 'update']]);
});

Route::get('/', function () {
    return view('welcome');
});
