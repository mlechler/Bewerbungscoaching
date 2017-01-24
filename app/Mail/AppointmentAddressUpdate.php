<?php

namespace App\Mail;

use App\Appointment;
use App\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentAddressUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $participant;
    public $oldaddress;
    public $seminarappointment;

    public function __construct(Member $participant, $oldaddress, Appointment $seminarappointment)
    {
        $this->participant = $participant;
        $this->oldaddress = $oldaddress;
        $this->seminarappointment = $seminarappointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment Update')->view('emails.appointmentupdateaddress');
    }
}
