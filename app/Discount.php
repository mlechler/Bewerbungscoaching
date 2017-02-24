<?php

namespace App;

use App\Presenters\DiscountPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class Discount extends Model implements HasPresenter
{
    protected $table = 'discounts';
    protected $fillable = ['title', 'amount', 'percentage', 'service', 'validity', 'permanent', 'startdate', 'code', 'expired'];

    public function getPresenterClass()
    {
        return DiscountPresenter::class;
    }
}
