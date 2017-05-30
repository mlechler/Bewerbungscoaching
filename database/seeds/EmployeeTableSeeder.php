<?php

use Illuminate\Database\Seeder;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('employees')->truncate();
        Employee::create(array(
            'lastname' => 'Lechler',
            'firstname' => 'Marcel',
            'birthday' => Carbon::createFromDate(1995, 6, 28),
            'phone' => '07031/123456',
            'mobile' => '01522/7891011',
            'email' => 'marcel.lechler@gmx.de',
            'address_id' => 1,
            'role_id' => 1,
            'color' => '#ff0000',
            'contribution' => 0,
            'password' => Hash::make('awesome'),
            'remember_token' => Auth::viaRemember()
        ));
        Employee::create(array(
            'lastname' => 'Müller',
            'firstname' => 'Bernd',
            'birthday' => Carbon::createFromDate(1990, 3, 12),
            'phone' => '07031/987654',
            'mobile' => '01522/1110987',
            'email' => 'scrat007@gmx.de',
            'address_id' => 2,
            'role_id' => 2,
            'color' => '#00ffe2',
            'contribution' => 0,
            'password' => Hash::make('awesome'),
            'remember_token' => Auth::viaRemember()
        ));
    }

}