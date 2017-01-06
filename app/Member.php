<?php

namespace App;

use App\Notifications\MemberResetPassword;
use App\Presenters\MemberPresenter;
use McCool\LaravelAutoPresenter\HasPresenter;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable implements HasPresenter
{
    use Notifiable;

    protected $table = 'members';
    protected $fillable = ['lastname', 'firstname', 'birthday', 'phone', 'mobile', 'email', 'adress_id', 'role_id', 'job', 'employer', 'university', 'courseofstudies', 'password', 'remember_token'];
    protected $hidden = ['password', 'remember_token'];
    protected $dates = ['birthday', 'last_login_at'];

    public function getPresenterClass()
    {
        return MemberPresenter::class;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MemberResetPassword($token));
    }

    public function adress()
    {
        return $this->belongsTo(Adress::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function memberFiles()
    {
        return $this->hasMany(Memberfile::class);
    }

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'seminarbookings')->withPivot('price_incl_discount', 'paid');
    }
}
