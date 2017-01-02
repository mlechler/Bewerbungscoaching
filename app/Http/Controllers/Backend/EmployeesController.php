<?php

namespace App\Http\Controllers\Backend;

use App\Employee;
use App\Adress;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EmployeesController extends Controller
{
    protected $employees;

    public function __construct(Employee $employees)
    {
        $this->employee = $employees;

        parent::__construct();
    }

    public function index()
    {
        $employees = Employee::paginate(10);

        return view('backend.employees.index', compact('employees'));
    }

    public function create(Employee $employee)
    {
        $adress = null;
        return view('backend.employees.form', compact('employee', 'adress'));
    }

    public function store(Requests\StoreEmployeeRequest $request)
    {
        $adress = Adress::where('zip', '=', $request->zip)->where('city', '=', $request->city)->where('street', '=', $request->street)->where('housenumber', '=', $request->housenumber)->first();

        if (!$adress) {
            $newadress = Adress::create(array(
                'zip' => $request->zip,
                'city' => $request->city,
                'street' => $request->street,
                'housenumber' => $request->housenumber
            ));
            $adress = $newadress;
        }

        Employee::create(array(
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'adress_id' => $adress->id,
            'password' => Hash::make($request->password),
            'remember_token' => Auth::viaRemember()
        ));

        return redirect(route('employees.index'))->with('status', 'Employee has been created.');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $adress = Adress::whereId($employee->adress_id)->first();

        return view('backend.employees.form', compact('employee', 'adress'));
    }

    public function update(Requests\UpdateEmployeeRequest $request, $id)
    {
        $adress = Adress::where('zip', '=', $request->zip)->where('city', '=', $request->city)->where('street', '=', $request->street)->where('housenumber', '=', $request->housenumber)->first();

        if (!$adress) {
            $newadress = Adress::create(array(
                'zip' => $request->zip,
                'city' => $request->city,
                'street' => $request->street,
                'housenumber' => $request->housenumber
            ));
            $adress = $newadress;
        }

        $employee = Employee::findOrFail($id);

        $employee->fill(array(
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'adress_id' => $adress->id,
            'password' => Hash::make($request->password),
            'remember_token' => Auth::viaRemember()
        ))->save();

        return redirect(route('employees.index'))->with('status', 'Employee has been updated.');
    }


    public function confirm(Requests\DeleteEmployeeRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);

        return view('backend.employees.confirm', compact('employee'));
    }

    public function destroy(Requests\DeleteEmployeeRequest $request, $id)
    {
        Employee::destroy($id);

        return redirect(route('employees.index'))->with('status', 'Employee has been deleted.');
    }
}
