<?php

namespace App;

use App\Events\ResetMemberPassword;
use App\Presenters\MemberPresenter;
use McCool\LaravelAutoPresenter\HasPresenter;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable implements HasPresenter
{
    use Notifiable;

    protected $table = 'members';
    protected $fillable = ['lastname', 'firstname', 'birthday', 'phone', 'mobile', 'email', 'address_id', 'role_id', 'job', 'employer', 'university', 'courseofstudies', 'password', 'remember_token'];
    protected $hidden = ['password', 'remember_token'];
    protected $dates = ['birthday', 'last_login_at'];

    public function getPresenterClass()
    {
        return MemberPresenter::class;
    }

    public function sendPasswordResetNotification($token)
    {
        event(new ResetMemberPassword($_REQUEST['email'], $token));
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function memberFiles()
    {
        return $this->hasMany(MemberFile::class);
    }

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'seminarbookings')->withPivot('price_incl_discount', 'paid');
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'memberdiscounts')->withPivot('validity', 'startdate', 'expired', 'cashedin');
    }

    public function individualCoachings()
    {
        return $this->hasMany(IndividualCoaching::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function applicationlayouts()
    {
        return $this->belongsToMany(ApplicationLayout::class, 'layoutpurchases')->withPivot('price_incl_discount', 'paid');
    }

    public function applicationpackages()
    {
        return $this->belongsToMany(ApplicationPackage::class, 'packagepurchases')->withPivot('price_incl_discount', 'paid');
    }
}
