<?php

namespace App\Http\Controllers\Backend;

use App\Appointment;
use App\Employee;
use App\Adress;
use App\Employeefile;
use App\Individualcoaching;
use App\Role;
use Illuminate\Support\Facades\Storage;
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
        $employees = Employee::orderBy('role_id')->paginate(10);

        return view('backend.employees.index', compact('employees'));
    }

    public function create(Employee $employee)
    {
        $roles = ['' => ''] + Role::all()->pluck('display_name', 'id')->toArray();

        return view('backend.employees.form', compact('employee', 'roles'));
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

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $this->storeFiles($files, $employee->id);
        }

        return redirect(route('employees.index'))->with('status', 'Employee has been created.');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);

        $roles = ['' => ''] + Role::all()->pluck('display_name', 'id')->toArray();

        return view('backend.employees.form', compact('employee', 'roles'));
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

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $this->storeFiles($files, $employee->id);
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

        $this->deleteFiles($id);
//        $this->deleteFreetimes($id);
        $this->deleteAppointments($id);
        $this->deleteCoachings($id);

        return redirect(route('employees.index'))->with('status', 'Employee has been deleted.');
    }

    public function detail($id)
    {
        $employee = Employee::findOrFail($id);

        return view('backend.employees.detail', compact('employee'));
    }

    public function storeFiles($files, $employee_id)
    {
        foreach ($files as $file) {
            $fileName = $file->getClientOriginalName();
            $fileType = $file->getClientMimeType();
            $destinationPath = config('app.fileDestinationPath') . '/employees/' . $employee_id . '/' . $fileName;
            $uploaded = Storage::put($destinationPath, file_get_contents($file->getRealPath()));

            if ($uploaded) {
                $employeefile = Employeefile::where('path', '=', $destinationPath)->first();

                if (!$employeefile) {
                    Employeefile::create(array(
                        'name' => $fileName,
                        'path' => $destinationPath,
                        'type' => $fileType,
                        'size' => filesize($file),
                        'employee_id' => $employee_id
                    ));
                }
            }
        }
    }

    public function deleteFiles($employee_id)
    {
        $employeefiles = Employeefile::all()->where('employee_id', '=', $employee_id);

        foreach ($employeefiles as $employeefile) {
            Storage::delete($employeefile->path);

            Employeefile::destroy($employeefile->id);
        }
    }

    public function deleteFile($file_id)
    {
        $employeefile = Employeefile::findOrFail($file_id);

        Storage::delete($employeefile->path);

        Employeefile::destroy($file_id);

        return redirect()->back()->with('status', 'File has been deleted.');
    }

    public function deleteAppointments($employee_id)
    {
        $appointments = Appointment::all()->where('employee_id', '=', $employee_id);

        foreach ($appointments as $appointment) {
            Appointment::destroy($appointment->id);
        }
    }

    public function deleteCoachings($employee_id)
    {
        $coachings = Individualcoaching::all()->where('employee_id', '=', $employee_id);

        foreach ($coachings as $coaching) {
            Individualcoaching::destroy($coaching->id);
        }
    }
}
