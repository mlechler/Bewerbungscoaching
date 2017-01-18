<?php

namespace App\Presenters;

use Carbon\Carbon;
use McCool\LaravelAutoPresenter\BasePresenter;

class EmployeeFreetimePresenter extends BasePresenter
{
    public function formatDate()
    {
        return Carbon::parse($this->date)->format('d.m.Y');
    }

    public function formatTime()
    {
        return Carbon::parse($this->starttime)->format('H:i').' - '.Carbon::parse($this->endtime)->format('H:i');
    }
}