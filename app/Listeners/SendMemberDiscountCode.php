<?php

namespace App\Listeners;

use App\Events\MakeMemberDiscount;
use App\Mail\MemberDiscountCode;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendMemberDiscountCode
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
     * @param  MakeMemberDiscount  $event
     * @return void
     */
    public function handle(MakeMemberDiscount $event)
    {
        Mail::to($event->memberdiscount->member->email)->send(new MemberDiscountCode($event->memberdiscount));
    }
}
