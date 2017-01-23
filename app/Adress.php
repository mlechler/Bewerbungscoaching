<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    protected $table = 'adresses';
    protected $fillable = ['zip', 'city', 'street', 'housenumber'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
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
