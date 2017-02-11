<?php

namespace App\Presenters;

use App\Task;
use McCool\LaravelAutoPresenter\BasePresenter;
use AlfredoRamos\ParsedownExtra\Facades\ParsedownExtra as Markdown;

class TaskPresenter extends BasePresenter
{
    public function getShortDescription()
    {
        $pieces = explode(" ", $this->descriptionHtml());
        $append = count($pieces) <= 10 ? null : ' ...';
        return (implode(" ", array_splice($pieces, 0, 10)) . $append);
    }

    public function highlight()
    {
        if ($this->finished) {
            return 'success';
        } elseif ($this->processing) {
            return 'warning';
        } else {
            return 'danger';
        }
    }

    public function descriptionHtml()
    {
        return ($this->description ? Markdown::parse($this->description) : null);
    }

    public function getName()
    {
        if($this->creator == null) {
            $task = Task::findOrFail($this->id);

            $task->fill(array('creator_id' => null))->save();
            return 'Creator not found';
        }
        return ($this->creator->lastname . ', ' . $this->creator->firstname);
    }

    public function processedBy()
    {
        return $this->processor->lastname . ', ' . $this->processor->firstname;
    }
}