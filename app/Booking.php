<?php

namespace App;

use App\Presenters\BookingPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class Booking extends Model implements HasPresenter
{
    protected $table = 'seminarbookings';
    protected $fillable = ['member_id', 'appointment_id', 'paid', 'price_incl_discount'];

    public function getPresenterClass()
    {
        return BookingPresenter::class;
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
