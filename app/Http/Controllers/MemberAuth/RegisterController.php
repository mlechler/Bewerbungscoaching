<?php

namespace App\Http\Controllers\MemberAuth;

use App\Address;
use App\Member;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('member.guest');
    }

    public function register(Requests\Frontend\RegisterNewMember $request)
    {
        $address = Address::where('zip', '=', $request->zip)->where('city', '=', $request->city)->where('street', '=', $request->street)->where('housenumber', '=', $request->housenumber)->first();

        if (!$address) {
            $newaddress = Address::create(array(
                'zip' => $request->zip,
                'city' => $request->city,
                'street' => $request->street,
                'housenumber' => $request->housenumber
            ));
            $address = $newaddress;
        }

        $member = Member::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address_id' => $address->id,
            'role_id' => 3,
            'job' => $request->job,
            'employer' => $request->employer,
            'university' => $request->university,
            'courseofstudies' => $request->courseofstudies,
            'password' => Hash::make($request->password),
            'remember_token' => Auth::viaRemember()
        ]);

        Auth::guard('member')->loginUsingId($member->id);

        return redirect('/')->with('status', 'Successfully registered. Welcome!');
    }

    public function showRegistrationForm()
    {
        return view('auth.member.register');
    }

    protected function guard()
    {
        return Auth::guard('member');
    }
}
