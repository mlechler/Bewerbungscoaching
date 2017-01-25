<?php

namespace App\Listeners;

use App\Events\MakePackagePurchase;
use App\Mail\PackagePurchaseConfirmation;
use Illuminate\Support\Facades\Mail;

class SendPackagePurchaseConfirmation
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
        Mail::to($event->packagepurchase->member->email)->send(new PackagePurchaseConfirmation($event->packagepurchase));
    }
}
