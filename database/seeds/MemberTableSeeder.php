<?php

use Illuminate\Database\Seeder;
use App\Member;
use Carbon\Carbon;

class MemberTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('members')->truncate();
        Member::create(array(
            'lastname' => 'Lechler',
            'firstname' => 'Marcel',
            'birthday' => Carbon::createFromDate(1995, 6, 28),
            'phone' => '123/456',
            'mobile' => '456/789',
            'email' => 'marcel.lechler@gmail.de',
            'job' => 'student',
            'employer' => 'HPE',
            'university' => 'DHBW',
            'courseofstudies' => 'AI',
            'password' => Hash::make('awesome')
        ));
        Member::create(array(
            'lastname' => 'L',
            'firstname' => 'Marcel',
            'birthday' => Carbon::createFromDate(1995, 6, 28),
            'phone' => '123/456',
            'mobile' => '456/7890',
            'email' => 'scrat007@gmx.de',
            'job' => 'student',
            'employer' => 'HPE',
            'university' => 'DHBW',
            'courseofstudies' => 'AI',
            'password' => Hash::make('awesome')
        ));
    }
}
