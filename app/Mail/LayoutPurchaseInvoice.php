<?php

namespace App\Mail;

use App\Invoice;
use App\Layoutpurchase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

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

    public function __construct(Layoutpurchase $layoutpurchase, Invoice $invoice)
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
