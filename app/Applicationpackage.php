<?php

namespace App;

use App\Presenters\ApplicationPackagePresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class ApplicationPackage extends Model implements HasPresenter
{
    protected $table = 'applicationpackages';
    protected $fillable = ['title', 'description', 'price'];

    public function getPresenterClass()
    {
        return ApplicationPackagePresenter::class;
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'packagepurchases')->withPivot('price_incl_discount', 'paid');
    }
}
