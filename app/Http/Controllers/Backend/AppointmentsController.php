<?php

namespace App\Http\Controllers\Backend;

use App\Appointment;
use Illuminate\Http\Request;
use App\Http\Requests;

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
        $seminarappointments = Appointment::with('employee')->paginate(10);

        return view('backend.seminarappointments.index', compact('seminarappointments'));
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function confirm()
    {

    }

    public function destroy()
    {

    }

    public function detail()
    {

    }
}
