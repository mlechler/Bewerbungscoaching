<?php

namespace App\Http\Controllers\Frontend;

use App\Seminar;

class SeminarsController extends Controller
{
    protected $seminars;

    public function __construct(Seminar $seminars)
    {
        $this->seminars = $seminars;
    }

    public function index()
    {
        return view('frontend.seminars');
    }
}
