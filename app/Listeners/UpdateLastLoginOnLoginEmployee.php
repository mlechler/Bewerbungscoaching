<?php

namespace App\Listeners;

use Carbon\Carbon;

class UpdateLastLoginOnLoginEmployee
{
    public function handle($event)
    {
        $event->user->last_login_at = Carbon::now();
        $event->user->save();
    }
}