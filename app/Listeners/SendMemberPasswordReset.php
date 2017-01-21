<?php

namespace App\Listeners;

use App\Events\ResetMemberPassword;
use App\Mail\MemberPasswordReset;
use Illuminate\Support\Facades\Mail;

class SendMemberPasswordReset
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

    public function handle(ResetMemberPassword $event)
    {
        Mail::to($event->email)->send(new MemberPasswordReset($event->token));
    }
}
