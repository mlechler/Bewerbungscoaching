<?php

namespace App\Listeners;

use App\Events\ExpireMemberDiscount;
use App\Mail\MemberDiscountExpiration;
use Illuminate\Support\Facades\Mail;

class SendMemberDiscountExpiration
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
     * @param  ExpireMemberDiscount  $event
     * @return void
     */
    public function handle(ExpireMemberDiscount $event)
    {
        Mail::to($event->memberdiscount->member->email)->send(new MemberDiscountExpiration($event->memberdiscount));
    }
}
