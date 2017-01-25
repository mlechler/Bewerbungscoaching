<?php

namespace App\Mail;

use App\LayoutPurchase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LayoutPurchaseConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $layoutpurchase;

    public function __construct(LayoutPurchase $layoutpurchase)
    {
        $this->layoutpurchase = $layoutpurchase;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Application Layout Purchase Confirmation')->view('emails.layoutpurchaseconfirmation');
    }
}
