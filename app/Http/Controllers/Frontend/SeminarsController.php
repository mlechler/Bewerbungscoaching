<?php

namespace App\Http\Controllers\Frontend;

use App\Appointment;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;

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
    }
}
