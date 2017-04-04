<?php

namespace App\Listeners;

use App\Events\RemindSeminarBooking;
use App\Mail\BookingReminder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendBookingReminder
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
     * @param  RemindSeminarBooking  $event
     * @return void
     */
    public function handle(RemindSeminarBooking $event)
    {
        Mail::to($event->booking->member->email)->send(new BookingReminder($event->booking));
    }
}
