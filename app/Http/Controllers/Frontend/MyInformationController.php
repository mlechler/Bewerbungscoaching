<?php

namespace App\Http\Controllers\Frontend;

use App\Address;
use App\Http\Requests;
use App\Member;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Illuminate\Support\Facades\Auth;

class MyInformationController extends Controller
{
    public function index()
    {
        return view('frontend.myinformation.index');
    }

    public function edit()
    {
        return view('frontend.myinformation.edit');
    }

    public function update(Requests\Frontend\UpdatePersonalInformationRequest $request, $id)
    {
        $address = Address::where('zip', '=', $request->zip)->where('city', '=', $request->city)->where('street', '=', $request->street)->where('housenumber', '=', $request->housenumber)->first();

        if (!$address) {
            $geo = Mapper::location('Germany' . $request->zip . $request->street . $request->housenumber);
            $newaddress = Address::create(array(
                'zip' => $request->zip,
                'city' => $request->city,
                'street' => $request->street,
                'housenumber' => $request->housenumber,
                'latitude' => $geo->getLatitude(),
                'longitude' => $geo->getLongitude()
            ));
            $address = $newaddress;
        }

        $member = Member::findOrFail($id);

        $oldpw = $member->password;

        $member->fill(array(
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address_id' => $address->id,
            'job' => $request->job,
            'employer' => $request->employer,
            'university' => $request->university,
            'courseofstudies' => $request->courseofstudies,
            'password' => $oldpw,
            'remember_token' => Auth::viaRemember()
        ))->save();

        return redirect(route('frontend.myinformation.index'))->with('status', 'Your Personal Information has been updated.');
    }
}