<?php

namespace App\Listeners;

use App\Events\RemindCoachingBooking;
use App\Mail\CoachingReminder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendCoachingReminder
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
     * @param  RemindCoachingBooking  $event
     * @return void
     */
    public function handle(RemindCoachingBooking $event)
    {
        Mail::to($event->coaching->member->email)->send(new CoachingReminder($event->coaching));
    }
}
