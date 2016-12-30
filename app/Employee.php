<?php

namespace App;

use App\Presenters\EmployeePresenter;
use McCool\LaravelAutoPresenter\HasPresenter;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable implements HasPresenter
{
    use Notifiable;

    protected $table = 'employees';
    protected $fillable = ['lastname', 'firstname', 'birthday', 'phone', 'mobile', 'email', 'password', 'remember_token'];
    protected $hidden = ['password', 'remember_token'];
    protected $date = ['birthday'];

    public function getPresenterClass()
    {
        return EmployeePresenter::class;
    }
}