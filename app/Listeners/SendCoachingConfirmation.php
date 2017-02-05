<?php

namespace App\Listeners;

use App\Events\MakeCoachingBooking;
use App\Mail\CoachingConfirmation;
use Illuminate\Support\Facades\Mail;

class SendCoachingConfirmation
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
        Mail::to($event->coaching->member->email)->send(new CoachingConfirmation($event->coaching));
    }
}
