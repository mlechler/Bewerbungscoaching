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
        return $time->format('H:i') . ' - ' . $time->addHours($this->seminar->duration)->format('H:i');
    }

    public function formatAddress()
    {
        return ($this->address->zip . ' ' . $this->address->city . ', ' . $this->address->street . ' ' . $this->address->housenumber);
    }

    public function overHighlight()
    {
        if ($this->date < Carbon::now()) {
            return 'danger';
        }
    }

    public function highlightPanel()
    {
        if ($this->seminar->maxMembers == $this->members->count()) {
            return 'danger';
        } else if ($this->seminar->maxMembers - $this->members->count() <= 5) {
            return 'warning';
        } else {
            return 'default';
        }
    }
}