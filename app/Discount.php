<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discounts';
    protected $fillable = ['amount', 'percentage', 'service'];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'memberdiscounts')->withPivot('validity', 'startdate', 'expired', 'cashedin');
    }
}
