<?php

namespace App\Http\Controllers\Backend;

use App\Address;
use App\Employee;
use App\EmployeeFreeTime;
use App\Http\Requests;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Illuminate\Support\Facades\Auth;

class EmployeeFreeTimesController extends Controller
{
    protected $freeimes;

    public function __construct(EmployeeFreeTime $freetimes)
    {
        $this->freetimes = $freetimes;

        parent::__construct();
    }

    public function index()
    {
        if (Auth::guard('employee')->user()->isAdmin()) {
            $freetimes = EmployeeFreeTime::with('employee')->paginate(10);
        } else {
            $freetimes = EmployeeFreeTime::with('employee')->where('employee_id', '=', Auth::guard('employee')->id())->paginate(10);
        }
        return view('backend.employeefreetimes.index', compact('freetimes'));
    }

    public function create(EmployeeFreeTime $freetime)
    {
        if (!Auth::guard('employee')->user()->isAdmin()) {
            $emp = Employee::select('id', 'lastname', 'firstname')->whereId(Auth::guard('employee')->id())->get();
            $employees = ['' => ''];
            foreach ($emp as $employee) {
                $employees[$employee->id] = $employee->lastname . ', ' . $employee->firstname;
            }
        } else {

            $emp = Employee::select('lastname', 'firstname')->get();
            $employees = ['' => ''];
            foreach ($emp as $employee) {
                array_push($employees, $employee->lastname . ', ' . $employee->firstname);
            }
            array_unshift($employees, '');
            unset($employees[0]);
        }

        return view('backend.employeefreetimes.form', compact('freetime', 'employees'));
    }

    public function store(Requests\Backend\StoreEmployeeFreeTimeRequest $request)
    {
        $overlap = $this->checkTimeOverlap($id = null, $request->employee_id, $request->date, $request->starttime, $request->endtime);

        $address = Address::where('zip', '=', $request->zip)->where('city', '=', $request->city)->where('street', '=', $request->street)->where('housenumber', '=', $request->housenumber)->first();

        if (!$address) {
            $geo = Mapper::location('Germany' . $request->zip . $request->street . $request->housenumber);
            $newaddress = Address::create(array(
                'zip' => $request->zip,
                'city' => $request->city,
                'street' => $request->street,
                'housenumber' => $request->housenumber,
                'latitude' => $geo->getLatitude(),
                'longitude' => $geo->getLongitude()
            ));
            $address = $newaddress;
        }

        if ($overlap) {
            return redirect(route('employeefreetimes.index'))->withErrors([
                'error' => 'Time Overlap detected.'
            ]);
        } else {
            EmployeeFreeTime::create(array(
                'date' => $request->date,
                'starttime' => $request->starttime,
                'endtime' => $request->endtime,
                'hourlyrate' => $request->hourlyrate,
                'services' => $request->services,
                'employee_id' => $request->employee_id,
                'address_id' => $address->id
            ));

            return redirect(route('employeefreetimes.index'))->with('status', 'Free Time has been created.');
        }
    }

    public function edit($id)
    {
        $freetime = EmployeeFreeTime::findOrFail($id);

        if (!Auth::guard('employee')->user()->isAdmin() && Auth::guard('employee')->id() != $freetime->employee_id) {
            return redirect(route('employeefreetimes.index'));
        }

        if (!Auth::guard('employee')->user()->isAdmin()) {
            $emp = Employee::select('id', 'lastname', 'firstname')->whereId(Auth::guard('employee')->id())->get();
            $employees = ['' => ''];
            foreach ($emp as $employee) {
                $employees[$employee->id] = $employee->lastname . ', ' . $employee->firstname;
            }
        } else {
            $emp = Employee::select('lastname', 'firstname')->get();
            $employees = ['' => ''];
            foreach ($emp as $employee) {
                array_push($employees, $employee->lastname . ', ' . $employee->firstname);
            }

            array_unshift($employees, '');
            unset($employees[0]);
        }
        return view('backend.employeefreetimes.form', compact('freetime', 'employees'));
    }

    public function update(Requests\Backend\UpdateEmployeeFreeTimeRequest $request, $id)
    {
        $freetime = EmployeeFreeTime::findOrFail($id);

        $overlap = $this->checkTimeOverlap($id, $request->employee_id, $request->date, $request->starttime, $request->endtime);

        $address = Address::where('zip', '=', $request->zip)->where('city', '=', $request->city)->where('street', '=', $request->street)->where('housenumber', '=', $request->housenumber)->first();

        if (!$address) {
            $geo = Mapper::location('Germany' . $request->zip . $request->street . $request->housenumber);
            $newaddress = Address::create(array(
                'zip' => $request->zip,
                'city' => $request->city,
                'street' => $request->street,
                'housenumber' => $request->housenumber,
                'latitude' => $geo->getLatitude(),
                'longitude' => $geo->getLongitude()
            ));
            $address = $newaddress;
        }

        if ($overlap) {
            return redirect(route('employeefreetimes.index'))->withErrors([
                'error' => 'Time Overlap detected.'
            ]);
        } else {
            $freetime->fill(array(
                'date' => $request->date,
                'starttime' => $request->starttime,
                'endtime' => $request->endtime,
                'hourlyrate' => $request->hourlyrate,
                'services' => $request->services,
                'employee_id' => $request->employee_id,
                'address_id' => $address->id
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

    public function checkTimeOverlap($id, $employee_id, $date, $starttime, $endtime)
    {
        $freetimes = EmployeeFreeTime::all()->where('employee_id', '=', $employee_id);

        foreach ($freetimes as $freetime) {
            if ($freetime->date == $date) {
                if (($freetime->starttime <= $endtime) && ($freetime->endtime >= $starttime)) {
                    if ($freetime->id != $id) {
                        return true;
                    }
                };
            }
        }
    }
}
