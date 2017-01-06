<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class SeminarPresenter extends BasePresenter
{
    public function getShortDescription($description)
    {
        $pieces = explode(" ", $description);
        return (implode(" ", array_splice($pieces, 0, 5)).' ...');
    }
}