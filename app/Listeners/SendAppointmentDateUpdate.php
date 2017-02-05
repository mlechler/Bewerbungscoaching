<?php

namespace App\Listeners;

use App\Events\ChangeAppointmentDateTime;
use App\Mail\AppointmentDateUpdate;
use Illuminate\Support\Facades\Mail;

class SendAppointmentDateUpdate
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
     * @param  ChangeAppointmentDateTime  $event
     * @return void
     */
    public function handle(ChangeAppointmentDateTime $event)
    {
        Mail::to($event->participant->email)->send(new AppointmentDateUpdate($event->participant, $event->olddate, $event->oldtime, $event->seminarappointment));
    }
}
