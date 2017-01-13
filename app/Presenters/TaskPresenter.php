<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;
use AlfredoRamos\ParsedownExtra\Facades\ParsedownExtra as Markdown;

class TaskPresenter extends BasePresenter
{
    public function getShortDescription($description)
    {
        $pieces = explode(" ", $description);
        return (implode(" ", array_splice($pieces, 0, 10)) . ' ...');
    }

    public function finishedHighlight()
    {
        if ($this->finished) {
            return 'success';
        } elseif (!$this->finished) {
            return 'danger';
        }
    }

    public function descriptionHtml()
    {
        return ($this->description ? Markdown::parse($this->description) : null);
    }
}