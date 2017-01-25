<?php

namespace App\Mail;

use App\Appointment;
use App\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentDateUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $participant;
    public $olddate;
    public $oldtime;
    public $seminarappointment;

    public function __construct(Member $participant, $olddate, $oldtime, Appointment $seminarappointment)
    {
        $this->participant = $participant;
        $this->olddate = $olddate;
        $this->oldtime = $oldtime;
        $this->seminarappointment = $seminarappointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment Update')->view('emails.appointmentupdatedatetime');
    }
}
