<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $fillable = ['member_id', 'individualcoaching_id', 'booking_id', 'date', 'totalprice'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function individualCoaching()
    {
        return $this->belongsTo(Individualcoaching::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
