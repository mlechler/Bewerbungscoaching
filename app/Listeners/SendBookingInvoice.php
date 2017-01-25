<?php

namespace App\Listeners;

use App\Events\MakeSeminarBooking;
use App\Mail\BookingInvoice;
use Illuminate\Support\Facades\Mail;

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
        Mail::to($event->booking->member->email)->send(new BookingInvoice($event->booking, $event->invoice));
    }
}
