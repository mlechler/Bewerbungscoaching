<?php

use Illuminate\Database\Seeder;
use App\Member;

class MemberTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('members')->delete();
        Member::create(array(
            'lastname' => 'Lechler',
            'firstname' => 'Marcel',
            'birthday' => '28.06.1995',
            'phone' => '123/456',
            'mobile' => '456/789',
            'email' => 'marcel.lechler@gmx.de',
            'job' => 'student',
            'employer' => 'HPE',
            'university' => 'DHBW',
            'courseofstudies' => 'AI',
            'password' => Hash::make('awesome')
        ));
        Member::create(array(
            'lastname' => 'L',
            'firstname' => 'Marcel',
            'birthday' => '28.06.1995',
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
