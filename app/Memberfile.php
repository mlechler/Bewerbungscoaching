<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memberfile extends Model
{
    protected $table = 'memberfiles';
    protected $fillable = ['name', 'type', 'size', 'content', 'checked', 'member_id'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
