<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memberdiscount extends Model
{
    protected $table = 'memberdiscounts';
    protected $fillable = ['member_id', 'discount_id', 'validity', 'startdate', 'expired', 'cashedin'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
