<?php

namespace App;

use App\Events\EmployeePasswordReset;
use App\Events\ResetEmployeePassword;
use App\Mail\PasswordReset;
use App\Notifications\EmployeeResetPassword;
use App\Presenters\EmployeePresenter;
use Doctrine\Instantiator\Exception\UnexpectedValueException;
use McCool\LaravelAutoPresenter\HasPresenter;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable implements HasPresenter
{
    use Notifiable;

    protected $table = 'employees';
    protected $fillable = ['lastname', 'firstname', 'birthday', 'phone', 'mobile', 'email', 'adress_id', 'role_id', 'password', 'remember_token'];
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

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function adress()
    {
        return $this->belongsTo(Adress::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function employeeFiles()
    {
        return $this->hasMany(Employeefile::class);
    }

    public function employeeFreeTimes()
    {
        return $this->hasMany(Employeefreetime::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function individualCoachings()
    {
        return $this->hasMany(Individualcoaching::class);
    }
}