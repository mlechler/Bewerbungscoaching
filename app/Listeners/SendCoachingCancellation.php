<?php

namespace App\Listeners;

use App\Events\CancelCoaching;
use App\Mail\CoachingCancellation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendCoachingCancellation
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
     * @param  CancelCoaching  $event
     * @return void
     */
    public function handle(CancelCoaching $event)
    {
        Mail::to($event->coaching->member->email)->send(new CoachingCancellation($event->coaching));
    }
}
