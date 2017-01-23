<?php

namespace App;

use App\Presenters\LayoutPurchasePresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class Layoutpurchase extends Model implements HasPresenter
{
    protected $table = 'layoutpurchases';
    protected $fillable = ['member_id', 'applicationlayout_id', 'paid', 'price_incl_discount'];

    public function getPresenterClass()
    {
        return LayoutPurchasePresenter::class;
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function applicationlayout()
    {
        return $this->belongsTo(Applicationlayout::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
