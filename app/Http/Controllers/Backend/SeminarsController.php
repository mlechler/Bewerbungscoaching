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

    public function create(Seminar $seminar)
    {
        return view('backend.seminars.form', compact('seminar'));
    }

    public function store(Requests\StoreSeminarRequest $request)
    {
        Seminar::create(array(
            'title' => $request->title,
            'description' => $request->description,
            'services' => $request->services,
            'maxMembers' => $request->maxMembers,
            'duration' => $request->duration,
            'price' => $request->price
        ));

        return redirect(route('seminars.index'))->with('status', 'Seminar has been created.');
    }

    public function edit($id)
    {
        $seminar = Seminar::findOrFail($id);

        return view('backend.seminars.form', compact('seminar'));
    }

    public function update(Requests\UpdateSeminarRequest $request, $id)
    {
        $seminar = Seminar::findOrFail($id);

        $seminar->fill(array(
            'title' => $request->title,
            'description' => $request->description,
            'services' => $request->services,
            'maxMembers' => $request->maxMembers,
            'duration' => $request->duration,
            'price' => $request->price
        ))->save();

        return redirect(route('seminars.index'))->with('status', 'Seminar has been updated.');
    }

    public function confirm($id)
    {
        $seminar = Seminar::findOrFail($id);

        return view('backend.seminars.confirm', compact('seminar'));
    }

    public function destroy($id)
    {
        Seminar::destroy($id);

        return redirect(route('seminars.index'))->with('status', 'Seminar has been deleted.');
    }
}
