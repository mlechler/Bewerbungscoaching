<?php

namespace App\Listeners;

use App\Events\MakeCoachingBooking;
use App\Mail\CoachingInvoice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendCoachingInvoice
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
     * @param  MakeCoachingBooking  $event
     * @return void
     */
    public function handle(MakeCoachingBooking $event)
    {
        Mail::to($event->coaching->member->email)->send(new CoachingInvoice($event->coaching, $event->invoice));
    }
}
