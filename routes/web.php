<?php

Route::group(['prefix' => 'employee'], function () {
    Route::get('/login', ['as' => 'employee.login', 'uses' => 'EmployeeAuth\LoginController@showLoginForm']);
    Route::post('/login', ['as' => 'employee.login', 'uses' => 'EmployeeAuth\LoginController@login']);
    Route::get('/logout', ['as' => 'employee.logout', 'uses' => 'EmployeeAuth\LoginController@logout']);

    Route::post('/password/email', ['as' => 'employee.password.email', 'uses' => 'EmployeeAuth\ForgotPasswordController@sendResetLinkEmail']);
    Route::post('/password/reset', ['as' => 'employee.password.reset', 'uses' => 'EmployeeAuth\ResetPasswordController@reset']);
    Route::get('/password/reset', ['as' => 'employee.password.reset', 'uses' => 'EmployeeAuth\ForgotPasswordController@showLinkRequestForm']);
    Route::get('/password/reset/{token}', ['as' => 'employee.password.reset.token', 'uses' => 'EmployeeAuth\ResetPasswordController@showResetForm']);
});

Route::group(['prefix' => 'member'], function () {
    Route::get('/login', ['as' => 'member.login', 'uses' => 'MemberAuth\LoginController@showLoginForm']);
    Route::post('/login', ['as' => 'member.login', 'uses' => 'MemberAuth\LoginController@login']);
    Route::get('/logout', ['as' => 'member.logout', 'uses' => 'MemberAuth\LoginController@logout']);

    Route::get('/register', ['as' => 'member.register', 'uses' => 'MemberAuth\RegisterController@showRegistrationForm']);
    Route::post('/register', ['as' => 'member.register', 'uses' => 'MemberAuth\RegisterController@register']);

    Route::post('/password/email', ['as' => 'member.password.email', 'uses' => 'MemberAuth\ForgotPasswordController@sendResetLinkEmail']);
    Route::post('/password/reset', ['as' => 'member.password.reset', 'uses' => 'MemberAuth\ResetPasswordController@reset']);
    Route::get('/password/reset', ['as' => 'member.password.reset', 'uses' => 'MemberAuth\ForgotPasswordController@showLinkRequestForm']);
    Route::get('/password/reset/{token}', ['as' => 'member.password.reset.token', 'uses' => 'MemberAuth\ResetPasswordController@showResetForm']);

    Route::get('/password/update', ['as' => 'member.password.update', 'uses' => 'MemberAuth\UpdatePasswordController@showUpdateForm']);
    Route::post('/password/update', ['as' => 'member.password.update', 'uses' => 'MemberAuth\UpdatePasswordController@update']);
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
        Route::get('/seminarappointments/{seminarappointment}/participantpaid/{participant}', ['as' => 'seminarappointments.participantPaid', 'uses' => 'Backend\AppointmentsController@participantPaid']);
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

        Route::get('/invoices/{invoice}/confirm', ['as' => 'invoices.confirm', 'uses' => 'Backend\InvoicesController@confirm']);
        Route::get('/invoices/{invoice}/detail', ['as' => 'invoices.detail', 'uses' => 'Backend\InvoicesController@detail']);
        Route::resource('/invoices', 'Backend\InvoicesController');

        Route::get('/pages/{page}/confirm', ['as' => 'pages.confirm', 'uses' => 'Backend\PagesController@confirm']);
        Route::get('/pages/{page}/detail', ['as' => 'pages.detail', 'uses' => 'Backend\PagesController@detail']);
        Route::resource('/pages', 'Backend\PagesController');

        Route::get('/todo/{todo}/confirm', ['as' => 'todo.confirm', 'uses' => 'Backend\TasksController@confirm']);
        Route::post('/todo/delete', ['as' => 'todo.deleteAllFinishedTasks', 'uses' => 'Backend\TasksController@deleteAllFinishedTasks']);
        Route::resource('/todo', 'Backend\TasksController');

        Route::get('/contact/{contact}/confirm', ['as' => 'contact.confirm', 'uses' => 'Backend\ContactController@confirm']);
        Route::delete('/contact/{contact}', ['as' => 'contact.destroy', 'uses' => 'Backend\ContactController@destroy']);
        Route::post('/contact/delete', ['as' => 'contact.deleteAllFinishedRequests', 'uses' => 'Backend\ContactController@deleteAllFinishedRequests']);
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
    Route::get('/seminarappointments/{seminarappointment}/list', ['as' => 'seminarappointments.list', 'uses' => 'Backend\AppointmentsController@createList']);
    Route::resource('/seminarappointments', 'Backend\AppointmentsController', ['only' => ['index']]);

    Route::get('/individualcoachings/{individualcoaching}/detail', ['as' => 'individualcoachings.detail', 'uses' => 'Backend\IndividualCoachingsController@detail']);
    Route::resource('/individualcoachings', 'Backend\IndividualCoachingsController', ['only' => ['index', 'create', 'store', 'edit', 'update']]);

    Route::get('/applicationpackages/{applicationpackage}/detail', ['as' => 'applicationpackages.detail', 'uses' => 'Backend\ApplicationPackagesController@detail']);
    Route::resource('/applicationpackages', 'Backend\ApplicationPackagesController', ['only' => ['index']]);

    Route::get('/packagepurchases/{packagepurchase}/detail', ['as' => 'packagepurchases.detail', 'uses' => 'Backend\PackagePurchasesController@detail']);
    Route::post('/packagepurchases/{packagepurchase}/uploadpackagefile', ['as' => 'packagepurchases.uploadPackageFile', 'uses' => 'Backend\PackagePurchasesController@uploadPackageFile']);

    Route::get('/blog/{blog}/confirm', ['as' => 'blog.confirm', 'uses' => 'Backend\BlogController@confirm']);
    Route::get('/blog/{blog}/detail', ['as' => 'blog.detail', 'uses' => 'Backend\BlogController@detail']);
    Route::resource('/blog', 'Backend\BlogController');

    Route::get('/todo/{todo}/detail', ['as' => 'todo.detail', 'uses' => 'Backend\TasksController@detail']);
    Route::get('/todo/{todo}/finished', ['as' => 'todo.finishedTask', 'uses' => 'Backend\TasksController@taskFinished']);
    Route::get('/todo/{todo}/process', ['as' => 'todo.processTask', 'uses' => 'Backend\TasksController@taskProcessing']);
    Route::resource('/todo', 'Backend\TasksController', ['only' => ['index', 'create', 'store', 'edit', 'update']]);

    Route::get('/contact', ['as' => 'contact.index', 'uses' => 'Backend\ContactController@index']);
    Route::get('/contact/{contact}/detail', ['as' => 'contact.detail', 'uses' => 'Backend\ContactController@detail']);
    Route::get('/contact/{contact}/process', ['as' => 'contact.processRequest', 'uses' => 'Backend\ContactController@requestProcessing']);
    Route::get('/contact/{contact}/finished', ['as' => 'contact.finishedRequest', 'uses' => 'Backend\ContactController@requestFinished']);
});

Route::group([], function () {
    Route::get('/', ['as' => 'frontend.welcome.index', 'uses' => 'Frontend\WelcomeController@index']);
    Route::group(['middleware' => 'member'], function () {
        Route::get('/myinformation', ['as' => 'frontend.myinformation.index', 'uses' => 'Frontend\MyInformationController@index']);
        Route::get('/myinformation/edit', ['as' => 'frontend.myinformation.edit', 'uses' => 'Frontend\MyInformationController@edit']);
        Route::post('/myinformation/edit', ['as' => 'frontend.myinformation.update', 'uses' => 'Frontend\MyInformationController@update']);
        Route::get('/myinformation/files', ['as' => 'frontend.myinformation.files', 'uses' => 'Frontend\MyInformationController@manageFiles']);
        Route::post('/myinformation/files', ['as' => 'frontend.myinformation.files', 'uses' => 'Frontend\MyInformationController@uploadFiles']);
        Route::get('/myinformation/files/delete', ['as' => 'frontend.myinformation.deleteAllFiles', 'uses' => 'Frontend\MyInformationController@deleteAllFiles']);
        Route::get('/myinformation/files/{file}/delete', ['as' => 'frontend.myinformation.deleteFile', 'uses' => 'Frontend\MyInformationController@deleteFile']);
    });

    Route::get('/seminars', ['as' => 'frontend.seminars.index', 'uses' => 'Frontend\SeminarsController@index']);
    Route::post('/seminars/makeBooking/{appointment}', ['as' => 'frontend.seminars.makeBooking', 'uses' => 'Frontend\SeminarsController@makeBooking']);

    Route::get('/individualcoachings', ['as' => 'frontend.individualcoachings.index', 'uses' => 'Frontend\IndividualCoachingsController@index']);

    Route::get('/applicationdocuments', ['as' => 'frontend.applicationdocuments.index', 'uses' => 'Frontend\ApplicationDocumentsController@index']);

    Route::get('/applicationpackages', ['as' => 'frontend.applicationpackages.index', 'uses' => 'Frontend\ApplicationPackagesController@index']);

    Route::get('/applicationlayouts', ['as' => 'frontend.applicationlayouts.index', 'uses' => 'Frontend\ApplicationLayoutsController@index']);

    //Generate the dynamic pages
    foreach (\App\Page::all() as $page) {
        Route::get($page->uri, ['as' => 'frontend.' . $page->name . '.index', function () use ($page) {
            return $this->app->call('App\Http\Controllers\Frontend\PagesController@show', [
                'page' => $page,
                'parameters' => Route::current()->parameters()
            ]);
        }]);
    }

    Route::post('/contact', ['as' => 'frontend.contact.store', 'uses' => 'Frontend\ContactController@store']);
});
