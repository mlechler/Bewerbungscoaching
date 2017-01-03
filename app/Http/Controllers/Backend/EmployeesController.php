<?php

namespace App\Http\Controllers\Backend;

use App\Employee;
use App\Adress;
use App\Employeefile;
use App\Role;
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

        $files = null;

        $roles = ['' => ''] + Role::all()->pluck('display_name', 'id')->toArray();

        return view('backend.employees.form', compact('employee', 'adress', 'roles', 'files'));
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

        $employee = Employee::create(array(
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'adress_id' => $adress->id,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
            'remember_token' => Auth::viaRemember()
        ));

        if ($request->hasFile('file')) {
            $this->storeFile($employee->id);
        }


        return redirect(route('employees.index'))->with('status', 'Employee has been created.');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);

        $adress = Adress::whereId($employee->adress_id)->first();

        $roles = ['' => ''] + Role::all()->pluck('display_name', 'id')->toArray();

        $files = Employeefile::where('employee_id', '=', $employee->id)->pluck('name', 'id')->toArray();

        return view('backend.employees.form', compact('employee', 'adress', 'roles', 'files'));
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
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
            'remember_token' => Auth::viaRemember()
        ))->save();

        if ($request->hasFile('file')) {
            $this->storeFile($employee->id);
        }

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

    public function storeFile($employee_id)
    {
        $fileName = $_FILES['file']['name'];
        $tmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];

        $fp = fopen($tmpName, 'r');
        $fileContent = fread($fp, fileSize($tmpName));
        $fileContent = addslashes($fileContent);
        fclose($fp);

        if (!get_magic_quotes_gpc()) {
            $fileName = addslashes($fileName);
        }

        Employeefile::create(array(
            'name' => $fileName,
            'type' => $fileType,
            'size' => $fileSize,
            'content' => $fileContent,
            'employee_id' => $employee_id
        ));
    }

}
