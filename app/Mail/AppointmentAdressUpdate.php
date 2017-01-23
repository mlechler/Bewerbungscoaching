<?php

namespace App\Mail;

use App\Appointment;
use App\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentAdressUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $participant;
    public $oldadress;
    public $seminarappointment;

    public function __construct(Member $participant, $oldadress, Appointment $seminarappointment)
    {
        $this->participant = $participant;
        $this->oldadress = $oldadress;
        $this->seminarappointment = $seminarappointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment Update')->view('emails.appointmentupdateadress');
    }
}
