<?php

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class PackagePurchasePresenter extends BasePresenter
{
    public function getFilename()
    {
        $pathParts = explode('/', $this->path);
        return $pathParts[count($pathParts)-1];
    }
}