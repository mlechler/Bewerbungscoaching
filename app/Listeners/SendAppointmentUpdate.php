<?php

namespace App\Listeners;

use App\Events\ChangeAppointmentDateTime;
use App\Mail\AppointmentUpdate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendAppointmentUpdate
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
        Mail::to($event->participant->email)->send(new AppointmentUpdate($event->participant, $event->olddate, $event->oldtime, $event->seminarappointment));
    }
}
