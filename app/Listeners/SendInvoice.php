<?php

namespace App\Listeners;

use App\Events\CreateInvoice;
use App\Mail\BookingInvoice;
use App\Mail\CoachingInvoice;
use App\Mail\LayoutPurchaseInvoice;
use App\Mail\PackagePurchaseInvoice;
use Illuminate\Support\Facades\Mail;

class SendInvoice
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
     * @param  CreateInvoice $event
     * @return void
     */
    public function handle(CreateInvoice $event)
    {
        switch ($event->type) {
            case 'coaching':
                Mail::to($event->invoice->member->email)->send(new CoachingInvoice($event->invoice->individualcoaching, $event->invoice));
                break;
            case 'seminar':
                Mail::to($event->invoice->member->email)->send(new BookingInvoice($event->invoice->booking, $event->invoice));
                break;
            case 'package':
                Mail::to($event->invoice->member->email)->send(new PackagePurchaseInvoice($event->invoice->packagepurchase, $event->invoice));
                break;
            case 'layout':
                Mail::to($event->invoice->member->email)->send(new LayoutPurchaseInvoice($event->invoice->layoutpurchase, $event->invoice));
                break;
            default:
                break;
        }
    }
}
