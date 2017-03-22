<?php

namespace App\Presenters;

use GrahamCampbell\Dropbox\Facades\Dropbox;
use McCool\LaravelAutoPresenter\BasePresenter;
use AlfredoRamos\ParsedownExtra\Facades\ParsedownExtra as Markdown;

class ApplicationLayoutPresenter extends BasePresenter
{
    public function descriptionHtml()
    {
        return ($this->description ? Markdown::parse($this->description) : null);
    }

    public function getFilenames()
    {
        $pathParts = explode('/', $this->layout);
        $previewParts = explode('/', $this->preview);
        return ($previewParts[count($previewParts) - 1] . ' / ' . $pathParts[count($pathParts) - 1]);
    }

    public function getPreviewFilename()
    {
        $previewParts = explode('/', $this->preview);
        return $previewParts[count($previewParts) - 1];
    }

    public function getLayoutFilename()
    {
        $pathParts = explode('/', $this->layout);
        return $pathParts[count($pathParts) - 1];
    }

    public function getPreview()
    {
        if ($this->preview) {
            $link = Dropbox::createShareableLink($this->preview);
            $newlink = substr($link, 0, -1);

            return '<a href="' . $link . '" target="_blank">
                                <img src="' . $newlink . '1&raw=1"
                                     style="width:200px; height:320px;"></a>';
        }

        return 'Currently no Preview available.';
    }
}