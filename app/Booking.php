<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'seminarbookings';
    protected $fillable = ['member_id', 'appointment_id', 'paid', 'price_incl_discount'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
