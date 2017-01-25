<?php

namespace App\Listeners;

use App\Events\MakeLayoutPurchase;
use App\Mail\LayoutPurchaseInvoice;
use Illuminate\Support\Facades\Mail;

class SendLayoutPurchaseInvoice
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
     * @param  MakeLayoutPurchase  $event
     * @return void
     */
    public function handle(MakeLayoutPurchase $event)
    {
        Mail::to($event->layoutpurchase->member->email)->send(new LayoutPurchaseInvoice($event->layoutpurchase, $event->invoice));
    }
}
