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
        return ($previewParts[count($previewParts)-1].' / '.$pathParts[count($pathParts)-1]);
    }

    public function getPreviewFilename()
    {
        $previewParts = explode('/', $this->preview);
        return $previewParts[count($previewParts)-1];
    }

    public function getLayoutFilename()
    {
        $pathParts = explode('/', $this->layout);
        return $pathParts[count($pathParts)-1];
    }

    public function getPreviewLink()
    {
        $link = Dropbox::createShareableLink($this->preview);
        substr($link, 0, -1);

        return $link;
    }

}