<?php

namespace App\Http\Controllers\Backend;

use App\Appointment;
use App\Booking;
use App\Member;
use Illuminate\Http\Request;
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

        return view('backend.seminarbookings.index', compact('seminarbookings'));
    }

    public function create(Booking $seminarbooking)
    {
        $mem = Member::select('lastname', 'firstname')->get();
        $members = [0 => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname.', '.$member->firstname);
        }

        $app = Appointment::select('seminar_id', 'date', 'time')->get();
        $appointments = [0 => ''];
        foreach ($app as $appointment) {
            $time = Carbon::parse($appointment->time);
            array_push($appointments, $appointment->seminar->title.', '.$appointment->date->format('d.m.Y').', '.($time->format('H:i') . ' - ' . $time->addHours($appointment->seminar->duration)->format('H:i')));
        }
        return view('backend.seminarbookings.form', compact('seminarbooking', 'members', 'appointments'));
    }

    public function store(Requests\StoreBookingRequest $request)
    {
        Booking::create(array(
            'member_id' => $request->member_id,
            'appointment_id' => $request->appointment_id,
            'price_incl_discount' => $request->price_incl_discount,
            'paid' => false
        ));

        return redirect(route('seminarbookings.index'))->with('status', 'Booking has been created.');
    }

    public function edit($id)
    {
        $seminarbooking = Booking::findOrFail($id);

        $mem = Member::select('lastname', 'firstname')->get();
        $members = [0 => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname.', '.$member->firstname);
        }

        $app = Appointment::select('seminar_id', 'date', 'time')->get();
        $appointments = [0 => ''];
        foreach ($app as $appointment) {
            $time = Carbon::parse($appointment->time);
            array_push($appointments, $appointment->seminar->title.', '.$appointment->date->format('d.m.Y').', '.($time->format('H:i') . ' - ' . $time->addHours($appointment->seminar->duration)->format('H:i')));
        }

        return view('backend.seminarbookings.form', compact('seminarbooking', 'members', 'appointments'));
    }

    public function update(Requests\UpdateBookingRequest $request, $id)
    {
        $seminarbooking = Booking::findOrFail($id);

        $seminarbooking->fill(array(
            'member_id' => $request->member_id,
            'appointment_id' => $request->appointment_id,
            'price_incl_discount' => $request->price_incl_discount
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
}
