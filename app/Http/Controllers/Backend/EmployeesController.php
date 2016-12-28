<?php

namespace App\Http\Controllers\Backend;

use App\Employee;
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
        return view('backend.employees.form', compact('employee'));
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('backend.employees.form', compact('employee'));
    }

    public function confirm($id)
    {
        echo $id;
    }

    public function update(Requests\UpdateEmployeeRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $employee->fill(array(
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => Auth::viaRemember()
        ))->save();

        return redirect('/admin/employees')->with('status', 'Employee has been updated.');
    }

    public function store(Requests\StoreEmployeeRequest $request)
    {
        Employee::create(array(
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => Auth::viaRemember()
        ));

        return redirect('/admin/employees')->with('status', 'Employee has been created.');
    }
}
