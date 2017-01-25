<?php

namespace App\Listeners;

use App\Events\MakeSeminarBooking;
use App\Mail\BookingConfirmation;
use Illuminate\Support\Facades\Mail;

class SendBookingConfirmation
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
        Mail::to($event->booking->member->email)->send(new BookingConfirmation($event->booking));
    }
}
