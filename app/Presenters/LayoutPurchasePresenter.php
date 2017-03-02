<?php

namespace App\Presenters;

use GrahamCampbell\Dropbox\Facades\Dropbox;
use McCool\LaravelAutoPresenter\BasePresenter;

class LayoutPurchasePresenter extends BasePresenter
{
    public function getDownload()
    {
        if ($this->applicationlayout->layout) {
            $link = Dropbox::createShareableLink($this->applicationlayout->layout);

            return '<a href="' . $link . '" target="_blank">Download</a>';
        }

        return 'Currently no Download available.';
    }
}