<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class MemberdiscountPresenter extends BasePresenter
{
    public function getValidity()
    {
        return ($this->startdate->format('d.m.Y').' - '.$this->startdate->addDays($this->validity)->format('d.m.Y'));
    }

    public function expirationHighlight(){
        if ($this->expired && $this->cashedin) {
            return 'warning';
        } elseif($this->expired && !$this->cashedin){
            return 'danger';
        }
    }
}