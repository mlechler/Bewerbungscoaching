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
        'App\Events\UploadMemberFile' => [
            'App\Listeners\CreateTaskCheckMemberFiles',
        ],
        'App\Events\PurchaseApplicationPackage' => [
            'App\Listeners\CreateTaskCreatePackageForMember',
        ],
        'App\Events\MakeSeminarBooking' => [
            'App\Listeners\SendBookingConfirmation',
            'App\Listeners\SendBookingInvoice',
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
