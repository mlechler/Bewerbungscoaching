<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;
use AlfredoRamos\ParsedownExtra\Facades\ParsedownExtra as Markdown;


class PagePresenter extends BasePresenter
{
    public function uriWildcard(){
        return $this->uri.'*';
    }

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

    public function contentHtml()
    {
        return Markdown::parse($this->pagecontent);
    }
}