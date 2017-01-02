<?php

namespace App;

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
        $this->notify(new EmployeeResetPassword($token));
    }

    public function adress()
    {
        return $this->belongsTo(Adress::class);
    }

    public function roles()
    {
        return $this->belongsTo(Role::class);
    }
}