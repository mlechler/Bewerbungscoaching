<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class MemberDiscountPresenter extends BasePresenter
{
    public function getValidity()
    {
        if ($this->permanent) {
            return 'Permanent';
        } else {
            return ($this->startdate->format('d.m.Y') . ' - ' . $this->startdate->addDays($this->validity)->format('d.m.Y'));
        }
    }

    public function expirationHighlight()
    {
        if ($this->expired && $this->cashedin) {
            return 'warning';
        } elseif ($this->expired && !$this->cashedin) {
            return 'danger';
        }
    }
}