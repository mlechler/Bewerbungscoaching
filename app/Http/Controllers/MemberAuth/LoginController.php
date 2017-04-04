<?php

namespace App\Http\Controllers\MemberAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    public $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('member.guest', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        return view('auth.member.login');
    }

    protected function guard()
    {
        return Auth::guard('member');
    }

    public function logout()
    {
        $this->guard()->logout();

        return redirect('/');
    }
}
