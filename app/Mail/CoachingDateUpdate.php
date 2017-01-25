<?php

namespace App\Mail;

use App\IndividualCoaching;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CoachingDateUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $olddate;
    public $oldtime;
    public $coaching;

    public function __construct(IndividualCoaching $coaching, $olddate, $oldtime)
    {
        $this->olddate = $olddate;
        $this->oldtime = $oldtime;
        $this->coaching = $coaching;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Individual Coaching Update')->view('emails.coachingupdatedatetime');
    }
}
