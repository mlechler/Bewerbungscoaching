<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AddLoggedInUser
{
    public function compose(View $view)
    {
        $view->with('loggedInUser', Auth::guard('member')->user());
    }
}