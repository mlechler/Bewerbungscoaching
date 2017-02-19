<?php

namespace App;

use App\Presenters\DiscountPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class Discount extends Model implements HasPresenter
{
    protected $table = 'discounts';
    protected $fillable = ['title', 'amount', 'percentage', 'service'];

    public function getPresenterClass()
    {
        return DiscountPresenter::class;
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'memberdiscounts')->withPivot('validity', 'permanent', 'startdate', 'code', 'expired', 'expirationMailSend', 'cashedin');
    }
}
