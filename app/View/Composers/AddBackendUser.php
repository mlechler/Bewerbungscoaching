<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AddBackendUser
{
    public function compose(View $view)
    {
        $view->with('backendUser', Auth::user());
    }
}