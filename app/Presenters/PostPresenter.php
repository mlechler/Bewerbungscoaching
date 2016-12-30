<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class PostPresenter extends BasePresenter
{
    public function getName()
    {
        return ($this->author->lastname . ' ' . $this->author->firstname);
    }

    public function publishedDate()
    {
        if ($this->published_at) {
            return $this->published_at->toFormattedDateString();
        }

        return 'Not Published';
    }

    public function publishedHighlight()
    {
        if($this->published_at && $this->published_at->isFuture()){
            return 'info';
        } elseif(! $this->published_at){
            return 'warning';
        }
    }
}