<?php

namespace App\Listeners;

use App\Events\MakeLayoutPurchase;
use App\Mail\LayoutPurchaseConfirmation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendLayoutPurchaseConfirmation
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
        Mail::to($event->layoutpurchase->member->email)->send(new LayoutPurchaseConfirmation($event->layoutpurchase));
    }
}
