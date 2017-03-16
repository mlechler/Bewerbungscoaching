<?php

namespace App\Http\Controllers\Frontend;

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

        $freetimes = EmployeeFreeTime::with('employee')->get();

        if (!$freetimes->isEmpty()) {
            foreach ($freetimes as $freetime) {
                $date = Carbon::createFromFormat('Y-m-d', $freetime->date);
                $starttime = Carbon::createFromFormat('H:i:s', $freetime->starttime);
                $endtime = Carbon::createFromFormat('H:i:s', $freetime->endtime);

                $start = $date->format('Y-m-d') . ' ' . $starttime->format('H:i:s');
                $end = $date->format('Y-m-d') . ' ' . $endtime->format('H:i:s');

                $event = Calendar::event(
                    $freetime->employee->lastname,
                    false,
                    $start,
                    $end
                );
                $calendar = Calendar::addEvent($event, [
                    'color' => '#800'
                ]);
            }
            $calendar->setOptions([
                'weekends' => false
            ]);
        }

        return view('frontend.individualcoachings', compact('calendar'));
    }
}
