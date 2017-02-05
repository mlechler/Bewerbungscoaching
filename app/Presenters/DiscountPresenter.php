<?php

namespace App\Presenters;

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
}