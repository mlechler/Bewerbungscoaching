<?php

namespace App\Mail;

use App\Appointment;
use App\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentCancellation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $participant;
    public $seminarappointment;

    public function __construct(Member $participant, Appointment $seminarappointment)
    {
        $this->participant = $participant;
        $this->seminarappointment = $seminarappointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment Cancellation')->view('emails.appointmentcancellation');
    }
}
