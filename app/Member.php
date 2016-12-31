<?php

namespace App;

use App\Presenters\MemberPresenter;
use McCool\LaravelAutoPresenter\HasPresenter;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable implements HasPresenter
{
    use Notifiable;

    protected $table = 'members';
    protected $fillable = ['lastname', 'firstname', 'birthday', 'phone', 'mobile', 'email', 'job', 'employer', 'university', 'courseofstudies', 'password'];
    protected $hidden = ['password'];
    protected $dates = ['birthday', 'last_login_at'];

    public function getPresenterClass()
    {
        return MemberPresenter::class;
    }
}
