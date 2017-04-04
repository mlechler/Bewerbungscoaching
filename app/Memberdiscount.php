<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memberdiscount extends Model
{
    protected $table = 'useddiscounts';
    protected $fillable = ['member_id', 'discount_id'];
}
