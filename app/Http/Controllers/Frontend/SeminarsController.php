<?php

namespace App\Http\Controllers\Frontend;

use App\Appointment;
use App\Booking;
use App\MemberDiscount;
use Illuminate\Http\Request;

class SeminarsController extends Controller
{
    protected $appointments;

    public function __construct(Appointment $appointments)
    {
        $this->appointments = $appointments;
    }

    public function index()
    {
        $appointments = Appointment::with('employee', 'seminar')->get();

        return view('frontend.seminars', compact('appointments'));
//        return view('frontend.seminars', compact('appointments'))->with('map', new MapController);
    }

    public function makeBooking(Request $request, $memberId, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        $memberdiscount = MemberDiscount::where('member_id', '=', $memberId)->where('code','=',$request->code)->get();

        if($memberdiscount) {
            $price_incl_discount = $this->useDiscount($memberdiscount);
        }

        Booking::create(array(
            'member_id' => $memberId,
            'appointment_id' => $appointmentId,
            'price_incl_discount' => $request->code ? $price_incl_discount : $appointment->seminar->price,
            'paid' => false,
            'reminderSend' => false,
        ));

        return redirect(route('frontend.seminars.index'))->with('status', 'Your Booking was successful!');
    }

    public function useDiscount($memberdiscount)
    {
        return 1;
    }
}
