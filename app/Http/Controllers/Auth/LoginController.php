<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin';
    protected $redirectAfterLogout = '/login';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function show(){
    }
}
