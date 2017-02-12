<?php

namespace App\Http\Controllers\Frontend;

use App\IndividualCoaching;

class IndividualCoachingsController extends Controller
{
    protected $coachings;

    public function __construct(IndividualCoaching $coachings)
    {
        $this->coachings = $coachings;
    }

    public function index()
    {
        return view('frontend.individualcoachings');
    }
}
