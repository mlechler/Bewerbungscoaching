<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class PagePresenter extends BasePresenter
{
    public function prettyURI()
    {
        return ('/'.ltrim($this->uri, '/'));
    }

    public function linkToPaddedTitle()
    {
        $padding = str_repeat('&nbsp;', $this->depth * 4);

        return $padding.$this->title;
    }

    public function paddedTitle()
    {
        return str_repeat('&nbsp;', $this->depth * 4).$this->title;
    }
}