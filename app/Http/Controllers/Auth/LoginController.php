<?php

namespace App\Http\Controllers\Auth;

use App\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'admin';
    protected $redirectAfterLogout = 'auth/login';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
}
