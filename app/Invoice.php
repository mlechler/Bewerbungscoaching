<?php

namespace App;

use App\Presenters\InvoicePresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class Invoice extends Model implements HasPresenter
{
    protected $table = 'invoices';
    protected $fillable = ['member_id', 'individualcoaching_id', 'booking_id', 'package_id', 'layout_id', 'date', 'totalprice'];
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
        return $this->belongsTo(Individualcoaching::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
