<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employeefile extends Model
{
    protected $table = 'employeefiles';
    protected $fillable = ['name', 'type', 'size', 'path', 'employee_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
