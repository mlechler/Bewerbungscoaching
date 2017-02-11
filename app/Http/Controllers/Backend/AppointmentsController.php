<?php

namespace App\Http\Controllers\Backend;

use App\Appointment;
use App\Events\CancelAppointment;
use App\Events\ChangeAppointmentAddress;
use App\Events\ChangeAppointmentDateTime;
use App\Seminar;
use App\Employee;
use App\Address;
use App\Booking;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{
    protected $appointments;

    public function __construct(Appointment $appointments)
    {
        $this->appointments = $appointments;

        parent::__construct();
    }

    public function index()
    {
        if(Auth::guard('employee')->user()->isAdmin()) {
            $seminarappointments = Appointment::with('employee')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $seminarappointments = Appointment::with('employee')->where('employee_id', '=', Auth::guard('employee')->id())->orderBy('created_at', 'desc')->paginate(10);
        }

        return view('backend.seminarappointments.index', compact('seminarappointments'));
    }

    public function create(Appointment $seminarappointment)
    {
        $seminars = ['' => ''] + Seminar::all()->pluck('title', 'id')->toArray();

        $emp = Employee::select('lastname', 'firstname')->get();
        $employees = ['' => ''];
        foreach ($emp as $employee) {
            array_push($employees, $employee->lastname.', '.$employee->firstname);
        }
        array_unshift($employees,'');
        unset($employees[0]);

        return view('backend.seminarappointments.form', compact('seminarappointment', 'seminars', 'employees'));
    }

    public function store(Requests\Backend\StoreAppointmentRequest $request)
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

        Appointment::create(array(
            'date' => $request->date,
            'time' => $request->time,
            'employee_id' => $request->employee_id,
            'seminar_id' => $request->seminar_id,
            'address_id' => $address->id
        ));

        return redirect(route('seminarappointments.index'))->with('status', 'Appointment has been created.');
    }

    public function edit($id)
    {
        $seminarappointment = Appointment::findOrFail($id);

        $seminars = ['' => ''] + Seminar::all()->pluck('title', 'id')->toArray();

        $emp = Employee::select('lastname', 'firstname')->get();
        $employees = ['' => ''];
        foreach ($emp as $employee) {
            array_push($employees, $employee->lastname.', '.$employee->firstname);
        }
        array_unshift($employees,'');
        unset($employees[0]);

        return view('backend.seminarappointments.form', compact('seminarappointment', 'seminars', 'employees'));
    }

    public function update(Requests\Backend\UpdateAppointmentRequest $request, $id)
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

        $seminarappointment = Appointment::findOrFail($id);

        $olddate = $seminarappointment->date;
        $oldtime = Carbon::parse($seminarappointment->time)->format('H:i');
        $oldaddress_id = $seminarappointment->address_id;

        $seminarappointment->fill(array(
            'date' => $request->date,
            'time' => $request->time,
            'employee_id' => $request->employee_id,
            'seminar_id' => $request->seminar_id,
            'address_id' => $address->id
        ))->save();

        if($olddate != $seminarappointment->date || $oldtime != $seminarappointment->time)
        {
            $participants = Booking::select('member_id')->where('appointment_id','=',$seminarappointment->id)->get();
            foreach($participants as $participant){
                event(new ChangeAppointmentDateTime($participant->member, $olddate, $oldtime, $seminarappointment));
            }
        }
        if($oldaddress_id != $seminarappointment->address_id)
        {
            $oldaddress = Address::findOrFail($oldaddress_id);
            $participants = Booking::select('member_id')->where('appointment_id','=',$seminarappointment->id)->get();
            foreach($participants as $participant){
                event(new ChangeAppointmentAddress($participant->member, $oldaddress, $seminarappointment));
            }
        }

        return redirect(route('seminarappointments.index'))->with('status', 'Appointment has been updated.');
    }

    public function confirm($id)
    {
        $seminarappointment = Appointment::findOrFail($id);

        return view('backend.seminarappointments.confirm', compact('seminarappointment'));
    }

    public function destroy($id)
    {
        $seminarappointment = Appointment::findOrFail($id);
        $participants = Booking::select('member_id')->where('appointment_id','=',$id)->get();
        foreach($participants as $participant){
            event(new CancelAppointment($participant->member, $seminarappointment));
        }

        Appointment::destroy($id);

        $this->deleteBookings($id);

        return redirect(route('seminarappointments.index'))->with('status', 'Appointment has been deleted.');
    }

    public function detail($id)
    {
        $seminarappointment = Appointment::with('employee', 'members')->findOrFail($id);

        return view('backend.seminarappointments.detail', compact('seminarappointment'));
    }

    public function removeParticipant($appointment_id, $member_id)
    {
        $booking = Booking::where('appointment_id', '=', $appointment_id)->where('member_id', '=', $member_id)->first();

        Booking::destroy($booking->id);

        return redirect()->back()->with('status', 'Participant has been removed.');
    }

    public function deleteBookings($appointment_id)
    {
        $bookings = Booking::all()->where('appointment_id', '=', $appointment_id);

        foreach ($bookings as $booking) {
            Booking::destroy($booking->id);
        }
    }
}
