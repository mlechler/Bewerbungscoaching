<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.dashboard')->with('backendUser', Auth::guard('employee')->user());
    }
}