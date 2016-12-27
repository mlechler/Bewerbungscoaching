<?php

namespace App\Http\Controllers\Backend;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Requests;

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
        $employees = Employee::all();

        return view('backend.employees.index', compact('employees'));
    }

    public function confirm($id)
    {
        //
    }
}
