<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;
use AlfredoRamos\ParsedownExtra\Facades\ParsedownExtra as Markdown;

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