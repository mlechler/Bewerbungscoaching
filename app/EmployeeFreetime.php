<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employeefreetime extends Model
{
    protected $table = 'employeefreetimes';
    protected $fillable = ['date', 'starttime', 'endtime', 'employee_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
