<?php

namespace App\Mail;

use App\IndividualCoaching;
use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CoachingInvoice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $coaching;
    public $invoice;

    public function __construct(IndividualCoaching $coaching, Invoice $invoice)
    {
        $this->coaching = $coaching;
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Individual Coaching Invoice')->view('emails.coachinginvoice');
    }
}
