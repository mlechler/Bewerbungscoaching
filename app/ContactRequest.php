<?php

namespace App;

use App\Presenters\ContactPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class ContactRequest extends Model implements HasPresenter
{
    protected $table = 'contactrequests';
    protected $fillable = ['name', 'email', 'message', 'processing', 'processedby', 'finished'];

    public function getPresenterClass()
    {
        return ContactPresenter::class;
    }

    public function processor()
    {
        return $this->belongsTo(Employee::class, 'processedby');
    }
}
