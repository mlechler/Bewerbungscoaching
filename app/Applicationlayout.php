<?php

namespace App;

use App\Presenters\ApplicationLayoutPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class Applicationlayout extends Model implements HasPresenter
{
    protected $table = 'applicationlayouts';
    protected $fillable = ['title', 'description', 'preview', 'layout', 'price'];

    public function getPresenterClass()
    {
        return ApplicationLayoutPresenter::class;
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'memberapplicationlayouts')->withPivot('price_incl_discount', 'paid');
    }
}
