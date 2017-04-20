<?php

namespace App;

use App\Events\ResetEmployeePassword;
use App\Presenters\EmployeePresenter;
use McCool\LaravelAutoPresenter\HasPresenter;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable implements HasPresenter
{
    use Notifiable;

    protected $table = 'employees';
    protected $fillable = ['lastname', 'firstname', 'birthday', 'phone', 'mobile', 'email', 'address_id', 'role_id', 'color', 'contribution', 'password', 'remember_token'];
    protected $hidden = ['password', 'remember_token'];
    protected $dates = ['birthday', 'last_login_at'];

    public function getPresenterClass()
    {
        return EmployeePresenter::class;
    }

    public function sendPasswordResetNotification($token)
    {
        event(new ResetEmployeePassword($_REQUEST['email'], $token));
    }

    public function isAdmin()
    {
        return $this->role->name == 'admin' ? true : false;
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function tasksCreated(){
        return $this->hasMany(Task::class);
    }

    public function tasksProcessed(){
        return $this->hasMany(Task::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function employeeFiles()
    {
        return $this->hasMany(EmployeeFile::class);
    }

    public function employeeFreeTimes()
    {
        return $this->hasMany(EmployeeFreeTime::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function individualCoachings()
    {
        return $this->hasMany(IndividualCoaching::class);
    }

    public function processedContactRequests()
    {
        return $this->hasMany(ContactRequest::class);
    }
}