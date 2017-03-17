<?php

namespace App\Http\Controllers\Frontend;

use App\Employee;
use App\EmployeeFreeTime;
use App\IndividualCoaching;
use Carbon\Carbon;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class IndividualCoachingsController extends Controller
{
    protected $coachings;

    public function __construct(IndividualCoaching $coachings)
    {
        $this->coachings = $coachings;
    }

    public function index()
    {
        $calendar = null;

        $employees = Employee::all();

        $freetimes = EmployeeFreeTime::with('employee')->get();

        if (!$freetimes->isEmpty()) {
            foreach ($freetimes as $freetime) {
                $date = Carbon::createFromFormat('Y-m-d', $freetime->date);
                $starttime = Carbon::createFromFormat('H:i:s', $freetime->starttime);
                $endtime = Carbon::createFromFormat('H:i:s', $freetime->endtime);

                $start = $date->format('Y-m-d') . ' ' . $starttime->format('H:i:s');
                $end = $date->format('Y-m-d') . ' ' . $endtime->format('H:i:s');

                $event = Calendar::event(
                    null,
                    false,
                    $start,
                    $end
                );
                $calendar = Calendar::addEvent($event, [
                    'color' => $freetime->employee->color,
                    'disableResizing' => true,
                    'url' => route('frontend.individualcoachings.detail', $freetime->id)
                ]);
            }
            $calendar->setOptions([
                'weekends' => false,
                'navLinks' => true
            ]);
        }

        return view('frontend.individualcoachings', compact('calendar', 'employees'));
    }

    public function detail($id)
    {
        dd($id);
    }
}
