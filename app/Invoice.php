<?php

namespace App;

use App\Presenters\InvoicePresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class Invoice extends Model implements HasPresenter
{
    protected $table = 'invoices';
    protected $fillable = ['member_id', 'individualcoaching_id', 'booking_id', 'packagepurchase_id', 'layoutpurchase_id', 'date', 'totalprice'];
    protected $dates = ['date'];

    public function getPresenterClass()
    {
        return InvoicePresenter::class;
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function individualcoaching()
    {
        return $this->belongsTo(IndividualCoaching::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function packagepurchase()
    {
        return $this->belongsTo(PackagePurchase::class);
    }

    public function layoutpurchase()
    {
        return $this->belongsTo(LayoutPurchase::class);
    }
}

