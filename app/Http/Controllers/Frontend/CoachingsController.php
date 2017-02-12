<?php

namespace App\Http\Controllers\Frontend;

use App\IndividualCoaching;

class CoachingsController extends Controller
{
    protected $coachings;

    public function __construct(IndividualCoaching $coachings)
    {
        $this->coachings = $coachings;
    }

    public function index()
    {
        dd('Hello, it\'s me, Individual Coachings');
    }
}
