<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;
use Carbon\Carbon;

class BookingPresenter extends BasePresenter
{
    public function formatDate()
    {
        return $this->appointment->date->format('d.m.Y');
    }

    public function formatTime()
    {
        $time = Carbon::parse($this->appointment->time);
        return $time->format('H:i') . ' - ' . $time->addHours($this->appointment->seminar->duration)->format('H:i');
    }

    public function getAppointment()
    {
        return ($this->appointment->seminar->title . ', ' . $this->formatDate() . ', ' . $this->formatTime());
    }
}