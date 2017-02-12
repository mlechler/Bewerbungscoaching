<?php

namespace App\Http\Controllers\Frontend;


use App\ApplicationLayout;

class ApplicationLayoutsController extends Controller
{
    protected $layouts;

    public function __construct(ApplicationLayout $layouts)
    {
        $this->layouts = $layouts;
    }

    public function index()
    {
        return view('frontend.applicationlayouts');
    }
}
