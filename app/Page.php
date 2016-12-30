<?php

namespace App;

use App\Presenters\PagePresenter;
use McCool\LaravelAutoPresenter\HasPresenter;
use Baum\Node;

class Page extends Node implements HasPresenter
{
    protected $table = 'pages';
    protected $fillable = ['title', 'name', 'uri', 'pagecontent', 'template'];

    public function getPresenterClass()
    {
        return PagePresenter::class;
    }

    public function updateOrder($order, $orderPage)
    {
        $orderPage = Page::findOrFail($orderPage);

        if($order == 'before') {
            $this->moveToLeftOf($orderPage);
        } elseif($order == 'after') {
            $this->moveToRightOf($orderPage);
        } elseif($order == 'childOf') {
            $this->makeChildOf($orderPage);
        }
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value ?: null;
    }

    public function setTemplateAttribute($value)
    {
        $this->attributes['template'] = $value ?: null;
    }
}
