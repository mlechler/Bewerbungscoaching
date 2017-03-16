<?php

namespace App;

use App\Presenters\EmployeeFreetimePresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;
use MaddHatter\LaravelFullcalendar\Event;

class EmployeeFreeTime extends Model implements HasPresenter, Event
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

    public function getId() {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function isAllDay()
    {
        //
    }

    public function getStart()
    {
        return $this->starttime;
    }

    public function getEnd()
    {
        return $this->endtime;
    }
}
