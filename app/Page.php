<?php

namespace App;

use App\Presenters\PagePresenter;
use McCool\LaravelAutoPresenter\HasPresenter;
use Illuminate\Database\Eloquent\Model;

class Page extends Model implements HasPresenter
{
    protected $table = 'pages';
    protected $fillable = ['title', 'name', 'uri', 'pagecontent'];

    public function getPresenterClass()
    {
        return PagePresenter::class;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value ?: null;
    }
}
