<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;
use Carbon\Carbon;

class AppointmentPresenter extends BasePresenter
{
    public function formatDate()
    {
        return $this->date->format('d.m.Y');
    }

    public function formatTime()
    {
        $time = Carbon::parse($this->time);
        return $time->format('H:i').' - '.$time->addMinutes($this->seminar->duration)->format('H:i');
    }

    public function formatAdress($adress)
    {
        return ($adress->zip.' '.$adress->city.', '.$adress->street.' '.$adress->housenumber);
    }
}