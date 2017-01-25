<?php

namespace App\Listeners;

use App\Events\ChangeCoachingAddress;
use App\Mail\CoachingAddressUpdate;
use Illuminate\Support\Facades\Mail;

class SendCoachingAddressUpdate
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
     * @param  ChangeCoachingAddress  $event
     * @return void
     */
    public function handle(ChangeCoachingAddress $event)
    {
        Mail::to($event->coaching->member->email)->send(new CoachingAddressUpdate($event->coaching, $event->oldaddress));
    }
}
