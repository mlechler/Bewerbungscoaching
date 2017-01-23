<?php

namespace App\Mail;

use App\Packagepurchase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PackagePurchaseConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $packagepurchase;

    public function __construct(Packagepurchase $packagepurchase)
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
