<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;
use AlfredoRamos\ParsedownExtra\Facades\ParsedownExtra as Markdown;

class ApplicationPackagePresenter extends BasePresenter
{
    public function descriptionHtml()
    {
        return ($this->description ? Markdown::parse($this->description) : null);
    }

    public function getShortDescription()
    {
        $pieces = explode(" ", $this->descriptionHtml());
        $append = count($pieces) <= 5 ? null : ' ...';
        return (implode(" ", array_splice($pieces, 0, 5)) . $append);
    }
}