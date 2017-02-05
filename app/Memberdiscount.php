<?php

namespace App;

use App\Presenters\MemberDiscountPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class MemberDiscount extends Model implements HasPresenter
{
    protected $table = 'memberdiscounts';
    protected $fillable = ['member_id', 'discount_id', 'validity', 'permanent', 'startdate', 'code', 'expired', 'expirationMailSend', 'cashedin'];
    protected $dates = ['startdate'];

    public function getPresenterClass()
    {
        return MemberDiscountPresenter::class;
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
