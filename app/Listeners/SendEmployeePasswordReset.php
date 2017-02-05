<?php

namespace App\Listeners;

use App\Events\ResetEmployeePassword;
use App\Mail\EmployeePasswordReset;
use Illuminate\Support\Facades\Mail;

class SendEmployeePasswordReset
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

    public function handle(ResetEmployeePassword $event)
    {
        Mail::to($event->email)->send(new EmployeePasswordReset($event->token));
    }
}
