<?php

namespace App\Http\Controllers\Backend;

use App\Appointment;
use App\Booking;
use App\Events\MakeSeminarBooking;
use App\Events\RemindSeminarBooking;
use App\Invoice;
use App\Mail\BookingReminder;
use App\Member;
use App\Seminar;
use App\Http\Requests;
use Carbon\Carbon;

class BookingsController extends Controller
{
    protected $bookings;

    public function __construct(Booking $bookings)
    {
        $this->bookings = $bookings;

        parent::__construct();
    }

    public function index()
    {
        $seminarbookings = Booking::with('member', 'appointment')->orderBy('created_at', 'desc')->paginate(10);

        $this->sendReminder();

        return view('backend.seminarbookings.index', compact('seminarbookings'));
    }

    public function create(Booking $seminarbooking)
    {
        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname . ', ' . $member->firstname);
        }
        array_unshift($members, '');
        unset($members[0]);

        $app = Appointment::select('seminar_id', 'date', 'time')->get();
        $appointments = ['' => ''];
        foreach ($app as $appointment) {
            $time = Carbon::parse($appointment->time);
            array_push($appointments, $appointment->seminar->title . ', ' . $appointment->date->format('d.m.Y') . ', ' . ($time->format('H:i') . ' - ' . $time->addHours($appointment->seminar->duration)->format('H:i')));
        }
        array_unshift($appointments, '');
        unset($appointments[0]);

        return view('backend.seminarbookings.form', compact('seminarbooking', 'members', 'appointments'));
    }

    public function store(Requests\Backend\StoreBookingRequest $request)
    {
        $appointment = Appointment::findOrfail($request->appointment_id);

        $seminar = Seminar::findOrFail($appointment->seminar_id);

        $price = $request->price_incl_discount > $seminar->price ? $seminar->price : $request->price_incl_discount;

        $bookings = Booking::all();

        foreach ($bookings as $booking) {
            if ($booking->member_id == $request->member_id && $booking->appointment_id == $request->appointment_id) {
                return redirect(route('seminarbookings.index'))->withErrors([
                    'error' => 'Member already booked this Appointment.'
                ]);
            }
            if ($booking->appointment->members) {
                if ($booking->appointment->members->count() == $seminar->maxMembers) {
                    return redirect(route('seminarbookings.index'))->withErrors([
                        'error' => 'No more Participants for this Appointment possible.'
                    ]);
                }
            }
        }

        $booking = Booking::create(array(
            'member_id' => $request->member_id,
            'appointment_id' => $request->appointment_id,
            'price_incl_discount' => $price,
            'paid' => false,
            'reminderSend' => false
        ));

        $invoice = Invoice::create(array(
            'member_id' => $request->member_id,
            'individualcoaching_id' => null,
            'booking_id' => $booking->id,
            'packagepurchase_id' => null,
            'layoutpurchase_id' => null,
            'totalprice' => $price,
            'date' => Carbon::now(),
        ));

        //event(new MakeSeminarBooking($booking, $invoice));

        return redirect(route('seminarbookings.index'))->with('status', 'Booking has been created.');
    }

    public function edit($id)
    {
        $seminarbooking = Booking::findOrFail($id);

        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname . ', ' . $member->firstname);
        }
        array_unshift($members, '');
        unset($members[0]);

        $app = Appointment::select('seminar_id', 'date', 'time')->get();
        $appointments = ['' => ''];
        foreach ($app as $appointment) {
            $time = Carbon::parse($appointment->time);
            array_push($appointments, $appointment->seminar->title . ', ' . $appointment->date->format('d.m.Y') . ', ' . ($time->format('H:i') . ' - ' . $time->addHours($appointment->seminar->duration)->format('H:i')));
        }
        array_unshift($appointments, '');
        unset($appointments[0]);

        return view('backend.seminarbookings.form', compact('seminarbooking', 'members', 'appointments'));
    }

    public function update(Requests\Backend\UpdateBookingRequest $request, $id)
    {
        $appointment = Appointment::findOrfail($request->appointment_id);
        $seminar = Seminar::findOrFail($appointment->seminar_id);
        $price = $request->price_incl_discount > $seminar->price ? $seminar->price : $request->price_incl_discount;

        $seminarbooking = Booking::findOrFail($id);

        $bookings = Booking::all();

        foreach ($bookings as $booking) {
            if ($seminarbooking->member_id == $request->member_id && $seminarbooking->appointment_id != $request->appointment_id) {
                if ($booking->member_id == $request->member_id && $booking->appointment_id == $request->appointment_id) {
                    return redirect(route('seminarbookings.index'))->withErrors([
                        'error' => 'Member already booked this Appointment.'
                    ]);
                }
                if ($booking->appointment->members->count() == $seminar->maxMembers) {
                    return redirect(route('seminarbookings.index'))->withErrors([
                        'error' => 'No more Participants for this Appointment possible.'
                    ]);
                }
            }
        }

        $seminarbooking->fill(array(
            'member_id' => $request->member_id,
            'appointment_id' => $request->appointment_id,
            'price_incl_discount' => $price
        ))->save();

        $invoice = Invoice::where('member_id', '=', $request->member_id)->where('booking_id', '=', $seminarbooking->id)->where('created_at', '=', $seminarbooking->created_at)->first();

        $invoice->fill(array(
            'totalprice' => $price
        ))->save();

        return redirect(route('seminarbookings.index'))->with('status', 'Booking has been updated.');
    }

    public function confirm($id)
    {
        $seminarbooking = Booking::findOrFail($id);

        return view('backend.seminarbookings.confirm', compact('seminarbooking'));
    }

    public function destroy($id)
    {
        Booking::destroy($id);

        return redirect(route('seminarbookings.index'))->with('status', 'Booking has been deleted.');
    }

    public function detail($id)
    {
        $seminarbooking = Booking::with('member', 'appointment')->findOrFail($id);

        return view('backend.seminarbookings.detail', compact('seminarbooking'));
    }

    public function sendReminder()
    {
        $bookings = Booking::all();

        foreach ($bookings as $booking) {
            if ($booking->appointment->date->subDays(7) < Carbon::now()) {
                if (!$booking->reminderSend) {
                    event(new RemindSeminarBooking($booking));
                    $booking->fill(array(
                        'reminderSend' => true
                    ))->save();
                }
            }
        }
    }
}
