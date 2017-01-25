<?php

namespace App\Listeners;

use App\Events\MakePackagePurchase;
use App\Mail\PackagePurchaseInvoice;
use Illuminate\Support\Facades\Mail;

class SendPackagePurchaseInvoice
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MakePackagePurchase  $event
     * @return void
     */
    public function handle(MakePackagePurchase $event)
    {
        Mail::to($event->packagepurchase->member->email)->send(new PackagePurchaseInvoice($event->packagepurchase, $event->invoice));
    }
}
