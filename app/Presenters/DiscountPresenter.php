<?php

namespace App\Presenters;

use Carbon\Carbon;
use McCool\LaravelAutoPresenter\BasePresenter;

class DiscountPresenter extends BasePresenter
{
    public function getAmountType()
    {
        if ($this->percentage) {
            return '%';
        } else {
            return '€';
        }
    }

    public function getValidity()
    {
        if ($this->permanent) {
            return 'Permanent';
        } else {
            return (Carbon::parse($this->startdate)->format('d.m.Y') . ' - ' . Carbon::parse($this->startdate)->addDays($this->validity)->format('d.m.Y'));
        }
    }

    public function expirationHighlight()
    {
        if ($this->expired) {
            return 'danger';
        }
    }
}