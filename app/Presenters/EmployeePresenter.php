<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class EmployeePresenter extends BasePresenter
{
    public function getName()
    {
        return ($this->lastname . ', ' . $this->firstname);
    }

    public function formatBirthday()
    {
        return $this->birthday->format('d.m.Y');
    }

    public function formatAddress()
    {
        return ($this->address->zip . ' ' . $this->address->city . ', ' . $this->address->street . ' ' . $this->address->housenumber);
    }

    public function lastLoginDifference()
    {
        return $this->last_login_at->diffForHumans();
    }
}