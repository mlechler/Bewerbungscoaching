<?php

namespace App;

use App\Presenters\EmployeeFreetimePresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class Employeefreetime extends Model implements HasPresenter
{
    protected $table = 'employeefreetimes';
    protected $fillable = ['date', 'starttime', 'endtime', 'employee_id'];

    public function getPresenterClass()
    {
        return EmployeeFreetimePresenter::class;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
