<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class EmployeePresenter extends BasePresenter
{
    public function getName()
    {
        return ($this->lastname.' '.$this->firstname);
    }
}