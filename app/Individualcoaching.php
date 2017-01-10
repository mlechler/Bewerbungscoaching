<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Individualcoaching extends Model
{
    protected $table = 'individualcoaching';
    protected $fillable = ['description', 'services', 'date', 'time', 'duration', 'price', 'trial', 'paid', 'member_id', 'employee_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
