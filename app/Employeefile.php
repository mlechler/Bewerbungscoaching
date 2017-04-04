<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeFile extends Model
{
    protected $table = 'employeefiles';
    protected $fillable = ['name', 'type', 'size', 'path', 'employee_id', 'download'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
