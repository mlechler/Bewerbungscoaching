<?php

namespace App\Http\Controllers\Frontend;

use App\Appointment;
use App\Booking;
use App\Events\MakeSeminarBooking;
use App\Invoice;
use App\MemberDiscount;
use Carbon\Carbon;
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

        $memberdiscount = MemberDiscount::with('discount')->where('member_id', '=', $memberId)->where('code', '=', $request->code)->where('expired', '=', false)->where('cashedin', '=', false)->first();

        $price_incl_discount = $appointment->seminar->price;

        if ($memberdiscount) {
            $price_incl_discount = $this->useDiscount($memberdiscount, $appointment);
        }

        $bookings = Booking::all();

        foreach ($bookings as $booking) {
            if ($booking->member_id == $memberId && $booking->appointment_id == $appointmentId) {
                return redirect(route('frontend.seminars.index'))->withErrors([
                    'error' => 'You have already booked this Appointment.'
                ]);
            }
        }

        $booking = Booking::create(array(
            'member_id' => $memberId,
            'appointment_id' => $appointmentId,
            'price_incl_discount' => $price_incl_discount,
            'paid' => false,
            'reminderSend' => false,
        ));

        $invoice = Invoice::create(array(
            'member_id' => $memberId,
            'individualcoaching_id' => null,
            'booking_id' => $booking->id,
            'packagepurchase_id' => null,
            'layoutpurchase_id' => null,
            'totalprice' => $price_incl_discount,
            'date' => Carbon::now(),
        ));

        event(new MakeSeminarBooking($booking, $invoice));

        return redirect(route('frontend.seminars.index'))->with('status', 'Your Booking was successful!');
    }

    public function useDiscount($memberdiscount, $appointment)
    {
        if ($memberdiscount->discount->service == 'Seminar' || $memberdiscount->discount->service == 'Universal') {

            if (!$memberdiscount->permanent) {
                $memberdiscount->fill(array(
                    'cashedin' => true
                ))->save();
            }

            if ($memberdiscount->discount->percentage) {
                return $appointment->seminar->price * $memberdiscount->discount->amount / 100;
            } else {
                if ($appointment->seminar->price - $memberdiscount->discount->amount < 0) {
                    return 0;
                } else {
                    return $appointment->seminar->price - $memberdiscount->discount->amount;
                }
            }
        } else {
            return $appointment->seminar->price;
        }
    }
}
