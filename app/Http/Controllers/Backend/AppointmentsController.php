<?php

namespace App\Http\Controllers\Backend;

use App\Appointment;
use App\Seminar;
use App\Employee;
use App\Adress;
use App\Booking;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\App;

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
        $seminarappointments = Appointment::with('employee')->orderBy('created_at', 'desc')->paginate(10);

        return view('backend.seminarappointments.index', compact('seminarappointments'));
    }

    public function create(Appointment $seminarappointment)
    {
        $seminars = ['' => ''] + Seminar::all()->pluck('title', 'id')->toArray();

        $emp = Employee::select('lastname', 'firstname')->get();
        $employees = [0 => ''];
        foreach ($emp as $employee) {
            array_push($employees, $employee->lastname.', '.$employee->firstname);
        }

        return view('backend.seminarappointments.form', compact('seminarappointment', 'seminars', 'employees'));
    }

    public function store(Requests\StoreAppointmentRequest $request)
    {
        $adress = Adress::where('zip', '=', $request->zip)->where('city', '=', $request->city)->where('street', '=', $request->street)->where('housenumber', '=', $request->housenumber)->first();

        if (!$adress) {
            $newadress = Adress::create(array(
                'zip' => $request->zip,
                'city' => $request->city,
                'street' => $request->street,
                'housenumber' => $request->housenumber
            ));
            $adress = $newadress;
        }

        Appointment::create(array(
            'date' => $request->date,
            'time' => $request->time,
            'employee_id' => $request->employee_id,
            'seminar_id' => $request->seminar_id,
            'adress_id' => $adress->id
        ));

        return redirect(route('seminarappointments.index'))->with('status', 'Appointment has been created.');
    }

    public function edit($id)
    {
        $seminarappointment = Appointment::findOrFail($id);

        $seminars = ['' => ''] + Seminar::all()->pluck('title', 'id')->toArray();

        $emp = Employee::select('lastname', 'firstname')->get();
        $employees = [0 => ''];
        foreach ($emp as $employee) {
            array_push($employees, $employee->lastname.', '.$employee->firstname);
        }

        return view('backend.seminarappointments.form', compact('seminarappointment', 'seminars', 'employees'));
    }

    public function update(Requests\UpdateAppointmentRequest $request, $id)
    {
        $adress = Adress::where('zip', '=', $request->zip)->where('city', '=', $request->city)->where('street', '=', $request->street)->where('housenumber', '=', $request->housenumber)->first();

        if (!$adress) {
            $newadress = Adress::create(array(
                'zip' => $request->zip,
                'city' => $request->city,
                'street' => $request->street,
                'housenumber' => $request->housenumber
            ));
            $adress = $newadress;
        }

        $seminarappointment = Appointment::findOrFail($id);

        $seminarappointment->fill(array(
            'date' => $request->date,
            'time' => $request->time,
            'employee_id' => $request->employee_id,
            'seminar_id' => $request->seminar_id,
            'adress_id' => $adress->id
        ))->save();

        return redirect(route('seminarappointments.index'))->with('status', 'Appointment has been updated.');
    }

    public function confirm($id)
    {
        $seminarappointment = Appointment::findOrFail($id);

        return view('backend.seminarappointments.confirm', compact('seminarappointment'));
    }

    public function destroy($id)
    {
        Appointment::destroy($id);

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
}
