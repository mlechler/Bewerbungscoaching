<?php

namespace App\Mail;

use App\Invoice;
use App\LayoutPurchase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LayoutPurchaseInvoice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $layoutpurchase;
    public $invoice;

    public function __construct(LayoutPurchase $layoutpurchase, Invoice $invoice)
    {
        $this->layoutpurchase = $layoutpurchase;
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Application Layout Purchase Invoice')->view('emails.layoutpurchaseinvoice');
    }
}
