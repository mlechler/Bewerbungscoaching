<?php

namespace App\Http\Controllers\Frontend;

use App\ApplicationPackage;

class ApplicationPackagesController extends Controller
{
    protected $packages;

    public function __construct(ApplicationPackage $packages)
    {
        $this->packages = $packages;
    }

    public function index()
    {
        return view('frontend.applicationpackages');
    }
}
