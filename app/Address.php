<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
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
        return $this->hasMany(IndividualCoaching::class);
    }
}
