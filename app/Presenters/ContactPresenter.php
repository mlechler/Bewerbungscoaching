<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;
use AlfredoRamos\ParsedownExtra\Facades\ParsedownExtra as Markdown;

class ContactPresenter extends BasePresenter
{
    public function getShortMessage()
    {
        $pieces = explode(" ", $this->message);
        $append = count($pieces) <= 5 ? null : ' ...';
        return (implode(" ", array_splice($pieces, 0, 5)) . $append);
    }

    public function processedBy()
    {
        return $this->processor->lastname . ', ' . $this->processor->firstname;
    }

    public function highlight()
    {
        if ($this->finished) {
            return 'success';
        } elseif ($this->processing) {
            return 'warning';
        }
    }
}