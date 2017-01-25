<?php

namespace App\Mail;

use App\Individualcoaching;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CoachingAddressUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $oldaddress;
    public $coaching;

    public function __construct(Individualcoaching $coaching, $oldaddress)
    {
        $this->oldaddress = $oldaddress;
        $this->coaching = $coaching;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Individual Coaching Update')->view('emails.coachingupdateaddress');
    }
}
