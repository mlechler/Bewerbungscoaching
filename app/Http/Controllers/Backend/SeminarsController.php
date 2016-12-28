<?php

namespace App\Http\Controllers\Backend;

use App\Seminar;
use Illuminate\Http\Request;
use App\Http\Requests;

class SeminarsController extends Controller
{
    protected $seminars;

    public function __construct(Seminar $seminars)
    {
        $this->seminars = $seminars;

        parent::__construct();
    }

    public function index()
    {
        $seminars = Seminar::paginate(10);

        return view('backend.seminars.index', compact('seminars'));
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function confirm()
    {

    }

    public function destroy()
    {

    }

}
