<?php

namespace App\Http\Controllers\Frontend;

use App\Appointment;
use App\Booking;
use App\Discount;
use App\Events\MakeSeminarBooking;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeminarsController extends Controller
{
    protected $appointments;

    public function __construct(Appointment $appointments)
    {
        $this->appointments = $appointments;
    }

    public function index()
    {
        $appointments = Appointment::with('employee', 'seminar')->where('date', '>', Carbon::now())->get();

        return view('frontend.seminars', compact('appointments'));
//        return view('frontend.seminars', compact('appointments'))->with('map', new MapController);
    }

    public function makeBooking(Request $request, $appointmentId)
    {
        $member = Auth::guard('member')->user();

        $appointment = Appointment::findOrFail($appointmentId);

        $discount = Discount::where('code', '=', $request->code)->where('expired', '=', false)->first();

        $price_incl_discount = $appointment->seminar->price;

        if ($discount) {
            $price_incl_discount = $this->useDiscount($discount, $appointment);
        }

        $bookings = Booking::all();

        foreach ($bookings as $booking) {
            if ($booking->member_id == $member->id && $booking->appointment_id == $appointmentId) {
                return redirect(route('frontend.seminars.index'))->withErrors([
                    'error' => 'You have already booked this Appointment.'
                ]);
            }
        }

        $booking = Booking::create(array(
            'member_id' => $member->id,
            'appointment_id' => $appointmentId,
            'price_incl_discount' => $price_incl_discount,
            'paid' => false,
            'reminderSend' => false,
        ));

        $invoice = Invoice::create(array(
            'member_id' => $member->id,
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

    public function useDiscount($discount, $appointment)
    {
        if ($discount->service == 'Seminar' || $discount->service == 'Universal') {

            if ($discount->percentage) {
                return $appointment->seminar->price * $discount->amount / 100;
            } else {
                if ($appointment->seminar->price - $discount->amount < 0) {
                    return 0;
                } else {
                    return $appointment->seminar->price - $discount->amount;
                }
            }
        } else {
            return $appointment->seminar->price;
        }
    }
}
