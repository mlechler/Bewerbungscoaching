<?php

namespace App\Http\Controllers\Backend;

use App\Employee;
use App\EmployeeFreeTime;
use App\Http\Requests;

class FreetimeController extends Controller
{
    protected $freetimes;

    public function __construct(EmployeeFreeTime $freetimes)
    {
        $this->freetimes = $freetimes;

        parent::__construct();
    }

    public function index()
    {
        $freetimes = EmployeeFreeTime::with('employee')->paginate(10);

        return view('backend.employeefreetimes.index', compact('freetimes'));
    }

    public function create(EmployeeFreeTime $freetime)
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

    public function store(Requests\StoreFreeTimeRequest $request)
    {
        $overlap = $this->checkTimeOverlap($request->employee_id, $request->date, $request->starttime, $request->endtime);

        if ($overlap) {
            return redirect(route('employeefreetimes.index'))->withErrors([
                'error' => 'Time Overlap detected.'
            ]);
        } else {
            EmployeeFreeTime::create(array(
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
        $freetime = EmployeeFreeTime::findOrFail($id);

        $emp = Employee::select('lastname', 'firstname')->get();
        $employees = ['' => ''];
        foreach ($emp as $employee) {
            array_push($employees, $employee->lastname . ', ' . $employee->firstname);
        }
        array_unshift($employees,'');
        unset($employees[0]);

        return view('backend.employeefreetimes.form', compact('freetime', 'employees'));
    }

    public function update(Requests\UpdateFreeTimeRequest $request, $id)
    {
        $freetime = EmployeeFreeTime::findOrFail($id);

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
        $freetime = EmployeeFreeTime::findOrFail($id);

        return view('backend.employeefreetimes.confirm', compact('freetime'));
    }

    public function destroy($id)
    {
        EmployeeFreeTime::destroy($id);

        return redirect(route('employeefreetimes.index'))->with('status', 'Free Time has been deleted.');
    }

    public function detail($id)
    {
        $freetime = EmployeeFreeTime::with('employee')->findOrFail($id);

        return view('backend.employeefreetimes.detail', compact('freetime'));
    }

    public function checkTimeOverlap($employee_id, $date, $starttime, $endtime)
    {
        $freetimes = EmployeeFreeTime::all()->where('employee_id', '=', $employee_id);

        foreach ($freetimes as $freetime) {
            if ($freetime->date == $date) {
                if (($freetime->starttime <= $endtime) && ($freetime->endtime >= $starttime)){
                    return true;
                };
            }
        }
    }
}
