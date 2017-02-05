<?php

namespace App;

use App\Presenters\AppointmentPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class Appointment extends Model implements HasPresenter
{
    protected $table = 'seminarappointments';
    protected $fillable = ['date', 'time', 'employee_id', 'seminar_id', 'address_id'];
    protected $dates = ['date'];

    public function getPresenterClass()
    {
        return AppointmentPresenter::class;
    }

    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'seminarbookings')->withPivot('price_incl_discount', 'paid');
    }
}
