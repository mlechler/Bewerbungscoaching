<?php

namespace App\Listeners;

use App\Events\CancelAppointment;
use App\Mail\AppointmentCancellation;
use Illuminate\Support\Facades\Mail;

class SendAppointmentCancellation
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
     * @param  CancelAppointment  $event
     * @return void
     */
    public function handle(CancelAppointment $event)
    {
        Mail::to($event->participant->email)->send(new AppointmentCancellation($event->participant, $event->seminarappointment));
    }
}
