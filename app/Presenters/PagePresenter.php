<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class PagePresenter extends BasePresenter
{
    public function prettyURI()
    {
        return ('/'.ltrim($this->uri, '/'));
    }
}