<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class MemberPresenter extends BasePresenter
{
    public function getName()
    {
        return ($this->lastname.' '.$this->firstname);
    }
}