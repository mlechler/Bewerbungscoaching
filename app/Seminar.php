<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    protected $table = 'seminars';
    protected $fillable = ['title', 'description', 'services', 'maxMembers', 'duration', 'price'];

    public function seminarFiles()
    {
        return $this->hasMany(Seminarfile::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
