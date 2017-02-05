<?php

namespace App\Http\Controllers\Frontend;

use App\Page;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function show(Page $page, array $parameters)
    {
        return view('frontend.page', compact('page'));
    }
}
