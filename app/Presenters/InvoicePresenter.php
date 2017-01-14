<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class InvoicePresenter extends BasePresenter
{
    public function formatDate()
    {
        return $this->date->format('d.m.Y');
    }
}