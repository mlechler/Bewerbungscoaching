<?php

namespace App\Listeners;

use App\Events\ChangeAppointmentAddress;
use App\Mail\AppointmentAddressUpdate;
use Illuminate\Support\Facades\Mail;

class SendAppointmentAddressUpdate
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
     * @param  ChangeAppointmentAddress  $event
     * @return void
     */
    public function handle(ChangeAppointmentAddress $event)
    {
        Mail::to($event->participant->email)->send(new AppointmentAddressUpdate($event->participant, $event->oldaddress, $event->seminarappointment));
    }
}
