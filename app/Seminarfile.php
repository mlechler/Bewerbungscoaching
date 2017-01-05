<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seminarfile extends Model
{
    protected $table = 'seminarfiles';
    protected $fillable = ['name', 'path', 'type', 'size','seminar_id'];

    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }
}