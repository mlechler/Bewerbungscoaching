<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use Notifiable;

    protected $table = 'employees';
    protected $fillable = ['lastname', 'firstname', 'birthday', 'phone', 'mobile', 'email', 'password', 'remember_token'];
}