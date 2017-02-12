<?php

namespace App;

use App\Presenters\IndividualCoachingPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class IndividualCoaching extends Model implements HasPresenter
{
    protected $table = 'individualcoachings';
    protected $fillable = ['services', 'date', 'time', 'duration', 'price_incl_discount', 'trial', 'paid', 'member_id', 'employee_id', 'address_id', 'reminderSend'];
    protected $dates = ['date'];

    public function getPresenterClass()
    {
        return IndividualCoachingPresenter::class;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
