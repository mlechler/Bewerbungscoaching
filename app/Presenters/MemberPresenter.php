<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class MemberPresenter extends BasePresenter
{
    public function getName()
    {
        return ($this->lastname . ', ' . $this->firstname);
    }

    public function formatBirthday()
    {
        return $this->birthday->format('d.m.Y');
    }

    public function formatAdress()
    {
        return ($this->adress->zip . ' ' . $this->adress->city . ', ' . $this->adress->street . ' ' . $this->adress->housenumber);
    }

    public function lastLoginDifference()
    {
        return $this->last_login_at->diffForHumans();
    }

    public function getUncheckedFiles()
    {
        foreach ($this->memberFiles as $file) {
            if (!$file->checked) {
                return 'alert-danger';
            }
        }
        return 'alert-success';
    }
}