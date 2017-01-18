<?php

namespace App\Http\Controllers\Backend;

use App\Employee;
use App\Employeefreetime;
use Illuminate\Http\Request;
use App\Http\Requests;

class FreetimeController extends Controller
{
    protected $freetimes;

    public function __construct(Employeefreetime $freetimes)
    {
        $this->freetimes = $freetimes;

        parent::__construct();
    }

    public function index()
    {
        $freetimes = Employeefreetime::with('employee')->paginate(10);

        return view('backend.employeefreetimes.index', compact('freetimes'));
    }

    public function create(Employeefreetime $freetime)
    {
        $emp = Employee::select('lastname', 'firstname')->get();
        $employees = ['' => ''];
        foreach ($emp as $employee) {
            array_push($employees, $employee->lastname . ', ' . $employee->firstname);
        }
        array_unshift($employees,'');
        unset($employees[0]);

        return view('backend.employeefreetimes.form', compact('freetime', 'employees'));
    }

    public function store(Requests\StoreFreetimeRequest $request)
    {
        $overlap = $this->checkTimeOverlap($request->employee_id, $request->date, $request->starttime, $request->endtime);

        if ($overlap) {
            return redirect(route('employeefreetimes.index'))->withErrors([
                'error' => 'Time Overlap detected.'
            ]);
        } else {
            Employeefreetime::create(array(
                'date' => $request->date,
                'starttime' => $request->starttime,
                'endtime' => $request->endtime,
                'employee_id' => $request->employee_id
            ));

            return redirect(route('employeefreetimes.index'))->with('status', 'Free Time has been created.');
        }
    }

    public function edit($id)
    {
        $freetime = Employeefreetime::findOrFail($id);

        $emp = Employee::select('lastname', 'firstname')->get();
        $employees = ['' => ''];
        foreach ($emp as $employee) {
            array_push($employees, $employee->lastname . ', ' . $employee->firstname);
        }
        array_unshift($employees,'');
        unset($employees[0]);

        return view('backend.employeefreetimes.form', compact('freetime', 'employees'));
    }

    public function update(Requests\UpdateFreetimeRequest $request, $id)
    {
        $freetime = Employeefreetime::findOrFail($id);

        $overlap = $this->checkTimeOverlap($request->employee_id, $request->date, $request->starttime, $request->endtime);

        if ($overlap) {
            return redirect(route('employeefreetimes.index'))->withErrors([
                'error' => 'Time Overlap detected.'
            ]);
        } else {
            $freetime->fill(array(
                'date' => $request->date,
                'starttime' => $request->starttime,
                'endtime' => $request->endtime,
                'employee_id' => $request->employee_id
            ))->save();

            return redirect(route('employeefreetimes.index'))->with('status', 'Free Time has been updated.');
        }
    }

    public function confirm($id)
    {
        $freetime = Employeefreetime::findOrFail($id);

        return view('backend.employeefreetimes.confirm', compact('freetime'));
    }

    public function destroy($id)
    {
        Employeefreetime::destroy($id);

        return redirect(route('employeefreetimes.index'))->with('status', 'Free Time has been deleted.');
    }

    public function detail($id)
    {
        $freetime = Employeefreetime::with('employee')->findOrFail($id);

        return view('backend.employeefreetimes.detail', compact('freetime'));
    }

    public function checkTimeOverlap($employee_id, $date, $starttime, $endtime)
    {
        $freetimes = Employeefreetime::all()->where('employee_id', '=', $employee_id);

        foreach ($freetimes as $freetime) {
            if ($freetime->date == $date) {
                if (($freetime->starttime <= $endtime) && ($freetime->endtime >= $starttime)){
                    return true;
                };
            }
        }
    }
}
