<?php

namespace App\Listeners;

use Carbon\Carbon;

class UpdateLastLoginOnLoginEmployee
{
    public function handle($user, $remember)
    {
        $user->fill(array(
            'last_login_at' => Carbon::now()
        ))->save();
    }
}