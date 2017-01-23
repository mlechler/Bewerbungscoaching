<?php

namespace App\Listeners;

use App\Events\ChangeAppointmentAdress;
use App\Mail\AppointmentAdressUpdate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendAppointmentAdressUpdate
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
     * @param  ChangeAppointmentAdress  $event
     * @return void
     */
    public function handle(ChangeAppointmentAdress $event)
    {
        Mail::to($event->participant->email)->send(new AppointmentAdressUpdate($event->participant, $event->oldadress, $event->seminarappointment));
    }
}
