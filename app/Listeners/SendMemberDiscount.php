<?php

namespace App\Listeners;

use App\Events\MakeMemberDiscount;
use App\Mail\MemberDiscount;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendMemberDiscount
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
        Mail::to($event->memberdiscount->member->email)->send(new MemberDiscount($event->memberdiscount));
    }
}
