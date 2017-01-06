<?php

namespace App;

use App\Presenters\SeminarPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class Seminar extends Model implements HasPresenter
{
    protected $table = 'seminars';
    protected $fillable = ['title', 'description', 'services', 'maxMembers', 'duration', 'price'];

    public function getPresenterClass()
    {
        return SeminarPresenter::class;
    }

    public function seminarFiles()
    {
        return $this->hasMany(Seminarfile::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
