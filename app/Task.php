<?php

namespace App;

use App\Presenters\TaskPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class Task extends Model implements HasPresenter
{
    protected $table = 'tasks';
    protected $fillable = ['title', 'description', 'creator_id', 'processing', 'processedby', 'finished'];

    public function getPresenterClass()
    {
        return TaskPresenter::class;
    }

    public function creator()
    {
        return $this->belongsTo(Employee::class);
    }

    public function processor()
    {
        return $this->belongsTo(Employee::class, 'processedby');
    }
}
