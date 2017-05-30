<?php

use Illuminate\Database\Seeder;
use App\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MemberTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('members')->truncate();
        Member::create(array(
            'lastname' => 'Bär',
            'firstname' => 'Hans',
            'birthday' => Carbon::createFromDate(1997, 4, 21),
            'phone' => '07033/637372',
            'mobile' => '0176/3764824',
            'email' => 'hb@gmx.de',
            'address_id' => 1,
            'role_id' => 3,
            'job' => 'student',
            'employer' => 'HPE',
            'university' => 'DHBW',
            'courseofstudies' => 'AI',
            'password' => Hash::make('awesome'),
            'remember_token' => Auth::viaRemember()
        ));
        Member::create(array(
            'lastname' => 'Wolf',
            'firstname' => 'Heinrich',
            'birthday' => Carbon::createFromDate(1998, 12, 24),
            'phone' => '07152/2748952',
            'mobile' => '0157/3634748',
            'email' => 'hw@gmx.de',
            'address_id' => 2,
            'role_id' => 3,
            'job' => 'student',
            'employer' => 'HPE',
            'university' => 'DHBW',
            'courseofstudies' => 'AI',
            'password' => Hash::make('awesome'),
            'remember_token' => Auth::viaRemember()
        ));
    }
}
