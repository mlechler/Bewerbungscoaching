<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\UpdateLastLoginOnLogin',
        ],
        'App\Events\ResetEmployeePassword' => [
            'App\Listeners\SendEmployeePasswordReset'
        ],
        'App\Events\ResetMemberPassword' => [
            'App\Listeners\SendMemberPasswordReset'
        ],
        'App\Events\UploadMemberFile' => [
            'App\Listeners\CreateTaskCheckMemberFiles',
        ],
        'App\Events\MakeMemberDiscount' => [
            'App\Listeners\SendMemberDiscountCode',
        ],
        'App\Events\ExpireMemberDiscount' => [
            'App\Listeners\SendMemberDiscountExpiration',
        ],
        'App\Events\MakeSeminarBooking' => [
            'App\Listeners\SendBookingConfirmation',
            'App\Listeners\SendBookingInvoice',
        ],
        'App\Events\MakeCoachingBooking' => [
            'App\Listeners\SendCoachingConfirmation',
            'App\Listeners\SendCoachingInvoice',
        ],
        'App\Events\MakePackagePurchase' => [
            'App\Listeners\CreateTaskCreatePackageForMember',
            'App\Listeners\SendPackagePurchaseConfirmation',
            'App\Listeners\SendPackagePurchaseInvoice',
        ],
        'App\Events\MakeLayoutPurchase' => [
            'App\Listeners\SendLayoutPurchaseConfirmation',
            'App\Listeners\SendLayoutPurchaseInvoice',
        ],
        'App\Events\ChangeAppointmentDateTime' => [
            'App\Listeners\SendAppointmentDateUpdate',
        ],
        'App\Events\ChangeCoachingDateTime' => [
            'App\Listeners\SendCoachingDateUpdate',
        ],
        'App\Events\ChangeAppointmentAddress' => [
            'App\Listeners\SendAppointmentAddressUpdate',
        ],
        'App\Events\ChangeCoachingAddress' => [
            'App\Listeners\SendCoachingAddressUpdate',
        ],
        'App\Events\CancelAppointment' => [
            'App\Listeners\SendAppointmentCancellation',
        ],
        'App\Events\CancelCoaching' => [
            'App\Listeners\SendCoachingCancellation',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
