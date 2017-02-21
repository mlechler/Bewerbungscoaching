<?php

namespace App\Http\Controllers\Frontend;

use App\Address;
use App\Appointment;
use App\Booking;
use App\Http\Requests;
use App\IndividualCoaching;
use App\LayoutPurchase;
use App\Member;
use App\PackagePurchase;
use Carbon\Carbon;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Illuminate\Support\Facades\Auth;

class MyInformationController extends Controller
{
    public function index()
    {
        $member = Auth::guard('member')->user();

        $bookings = Booking::where('member_id', '=', $member->id)->get();
        $seminars = [];
        $formerseminars = [];

        foreach($bookings as $booking){
            if($booking->appointment->date >= Carbon::now()){
                array_push($seminars, $booking);
            } else {
                array_push($formerseminars, $booking);
            }
        }

        $individualcoachings = IndividualCoaching::where('member_id', '=', $member->id)->get();
        $coachings = [];
        $formercoachings = [];

        foreach($individualcoachings as $individualcoaching){
            if($individualcoaching->date >= Carbon::now()){
                array_push($coachings, $individualcoaching);
            } else {
                array_push($formercoachings, $individualcoaching);
            }
        }

        $layoutpurchases = LayoutPurchase::where('member_id', '=', $member->id)->get();
        $applicationlayouts = [];

        foreach($layoutpurchases as $layoutpurchase) {
            array_push($applicationlayouts, $layoutpurchase);
        }

        $packagepurchases = PackagePurchase::where('member_id', '=', $member->id)->get();
        $applicationpackages = [];

        foreach($packagepurchases as $packagepurchase) {
            array_push($applicationpackages, $packagepurchase);
        }

        return view('frontend.myinformation.index', compact('seminars','formerseminars', 'coachings', 'formercoachings', 'applicationlayouts', 'applicationpackages'));
    }

    public function edit()
    {
        return view('frontend.myinformation.edit');
    }

    public function update(Requests\Frontend\UpdatePersonalInformationRequest $request)
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

        $member = $this->getUser();

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

    public function getUser()
    {
        return Auth::guard('member')->user();
    }
}