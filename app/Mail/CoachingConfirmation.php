<?php

namespace App\Mail;

use App\IndividualCoaching;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CoachingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $coaching;

    public function __construct(IndividualCoaching $coaching)
    {
        $this->coaching = $coaching;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Individual Coaching Confirmation')->view('emails.coachingconfirmation');
    }
}
