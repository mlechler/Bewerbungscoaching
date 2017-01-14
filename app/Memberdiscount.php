<?php

namespace App;

use App\Presenters\MemberdiscountPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class Memberdiscount extends Model implements HasPresenter
{
    protected $table = 'memberdiscounts';
    protected $fillable = ['member_id', 'discount_id', 'validity', 'startdate', 'expired', 'cashedin'];
    protected $dates = ['startdate'];

    public function getPresenterClass()
    {
        return MemberdiscountPresenter::class;
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
