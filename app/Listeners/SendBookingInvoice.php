<?php

namespace App\Listeners;

use App\Events\MakeSeminarBooking;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBookingInvoice
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MakeSeminarBooking  $event
     * @return void
     */
    public function handle(MakeSeminarBooking $event)
    {
        //
    }
}
