<?php

namespace App\Mail;

use App\PackagePurchase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PackagePurchaseConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $packagepurchase;

    public function __construct(PackagePurchase $packagepurchase)
    {
        $this->packagepurchase = $packagepurchase;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Application Package Purchase Confirmation')->view('emails.packagepurchaseconfirmation');
    }
}
