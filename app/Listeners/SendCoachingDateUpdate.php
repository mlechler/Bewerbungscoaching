<?php

namespace App\Listeners;

use App\Events\ChangeCoachingDateTime;
use App\Mail\CoachingDateUpdate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendCoachingDateUpdate
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
     * @param  ChangeCoachingDateTime  $event
     * @return void
     */
    public function handle(ChangeCoachingDateTime $event)
    {
        Mail::to($event->coaching->member->email)->send(new CoachingDateUpdate($event->coaching, $event->olddate, $event->oldtime));
    }
}
