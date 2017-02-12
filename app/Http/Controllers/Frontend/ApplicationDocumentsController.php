<?php

namespace App\Http\Controllers\Frontend;


class ApplicationDocumentsController extends Controller
{
    public function index(){
        return view('frontend.applicationdocuments');
    }
}
