<?php

namespace App\Mail;

use App\MemberDiscount;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberDiscountExpiration extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $memberdiscount;

    public function __construct(MemberDiscount $memberdiscount)
    {
        $this->memberdiscount = $memberdiscount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Member Discount Expiration')->view('emails.memberdiscountexpiration');
    }
}