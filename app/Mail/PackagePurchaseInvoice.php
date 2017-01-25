<?php

namespace App\Mail;

use App\Invoice;
use App\PackagePurchase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PackagePurchaseInvoice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $packagepurchase;
    public $invoice;

    public function __construct(PackagePurchase $packagepurchase, Invoice $invoice)
    {
        $this->packagepurchase = $packagepurchase;
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Application Package Purchase Invoice')->view('emails.packagepurchaseinvoice');
    }
}
