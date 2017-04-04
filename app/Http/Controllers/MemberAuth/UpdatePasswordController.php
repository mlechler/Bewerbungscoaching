<?php

namespace App\Http\Controllers\MemberAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UpdatePasswordController extends Controller
{
    public $redirectTo = '/myinformation';

    public function __construct()
    {
        $this->middleware('member');
    }

    public function showUpdateForm()
    {
        return view('auth.member.passwords.update');
    }

    public function update(Requests\Frontend\UpdateMemberPasswordRequest $request)
    {
        $member = Member::where('email', '=', $request->email)->first();

        if(!Hash::check($request->old_password, $member->password)) {
            return redirect()->back()->withErrors([
                'oldpw' => 'Wrong Old Password'
            ]);
        }

        $member->fill(array(
            'password' => Hash::make($request->password),
            'remember_token' => Auth::viaRemember()
        ))->save();

        return redirect(route('frontend.myinformation.index'))->with('status','Password has been updated');
    }

    public function broker()
    {
        return Password::broker('members');
    }

    protected function guard()
    {
        return Auth::guard('member');
    }
}
