<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberFile extends Model
{
    protected $table = 'memberfiles';
    protected $fillable = ['name', 'type', 'size', 'path', 'checked', 'member_id', 'download'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
