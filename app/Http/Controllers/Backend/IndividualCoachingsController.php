<?php

namespace App\Http\Controllers\Backend;

use App\Individualcoaching;
use App\Employee;
use App\Member;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\App;

class IndividualCoachingsController extends Controller
{
    protected $coachings;

    public function __construct(Individualcoaching $coachings)
    {
        $this->coachings = $coachings;

        parent::__construct();
    }

    public function index()
    {
        $coachings = Individualcoaching::with('employee', 'member')->paginate(10);

        return view('backend.individualcoachings.index', compact('coachings'));
    }

    public function create(Individualcoaching $coaching)
    {
        $employees = ['' => ''] + Employee::all()->pluck('lastname', 'id')->toArray();

        $members = ['' => ''] + Member::all()->pluck('lastname', 'id')->toArray();

        return view('backend.individualcoachings.form', compact('coaching', 'employees', 'members'));
    }

    public function store(Requests\StoreCoachingRequest $request)
    {
        Individualcoaching::create(array(
            'services' => $request->services,
            'date' => $request->date,
            'time' => $request->time,
            'duration' => $request->duration,
            'price' => $request->price,
            'trial' => $request->trial == 'on' ? true : false,
            'employee_id' => $request->employee_id,
            'member_id' => $request->member_id,
            'paid' => $request->trial == 'on' ? true : false,
        ));

        return redirect(route('individualcoachings.index'))->with('status', 'Coaching has been created.');
    }

    public function edit($id)
    {
        $coaching = Individualcoaching::findOrFail($id);

        $members = ['' => ''] + Member::all()->pluck('lastname', 'id')->toArray();

        $employees = ['' => ''] + Employee::all()->pluck('lastname', 'id')->toArray();

        return view('backend.individualcoachings.form', compact('coaching', 'employees', 'members'));
    }

    public function update(Requests\UpdateCoachingRequest $request, $id)
    {
        $coaching = Individualcoaching::findOrFail($id);

        $coaching->fill(array(
            'services' => $request->services,
            'date' => $request->date,
            'time' => $request->time,
            'duration' => $request->duration,
            'price' => $request->price,
            'trial' => $request->trial == 'on' ? true : false,
            'employee_id' => $request->employee_id,
            'member_id' => $request->member_id
        ))->save();

        return redirect(route('individualcoachings.index'))->with('status', 'Coaching has been updated.');
    }

    public function confirm($id)
    {
        $coaching = Individualcoaching::findOrFail($id);

        return view('backend.individualcoachings.confirm', compact('coaching'));
    }

    public function destroy($id)
    {
        Individualcoaching::destroy($id);

        return redirect(route('individualcoachings.index'))->with('status', 'Coaching has been deleted.');
    }

    public function detail($id)
    {
        $coaching = Individualcoaching::with('employee', 'member')->findOrFail($id);

        return view('backend.individualcoachings.detail', compact('coaching'));
    }
}
