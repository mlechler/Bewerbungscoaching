<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class SeminarPresenter extends BasePresenter
{
    public function getShortDescription()
    {
        $pieces = explode(" ", $this->description);
        return (implode(" ", array_splice($pieces, 0, 5)).' ...');
    }
}