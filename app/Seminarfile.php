<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seminarfile extends Model
{
    protected $table = 'seminarfiles';
    protected $fillable = ['name', 'type', 'size', 'content','seminar_id'];

    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }
}
