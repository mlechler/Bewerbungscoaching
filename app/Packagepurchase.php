<?php

namespace App;

use App\Presenters\PackagePurchasePresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class PackagePurchase extends Model implements HasPresenter
{
    protected $table = 'packagepurchases';
    protected $fillable = ['member_id', 'applicationpackage_id', 'paid', 'price_incl_discount', 'path', 'packageDownload'];

    public function getPresenterClass()
    {
        return PackagePurchasePresenter::class;
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function applicationpackage()
    {
        return $this->belongsTo(ApplicationPackage::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}