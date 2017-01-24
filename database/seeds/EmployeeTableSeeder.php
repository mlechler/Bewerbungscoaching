<?php

use Illuminate\Database\Seeder;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EmployeeTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('employees')->truncate();
        Employee::create(array(
            'lastname' => 'Lechler',
            'firstname' => 'Marcel',
            'birthday' => Carbon::createFromDate(1995, 6, 28),
            'phone' => '123/456',
            'mobile' => '456/789',
            'email' => 'marcel.lechler@gmx.de',
            'address_id' => 1,
            'role_id' => 1,
            'password' => Hash::make('awesome'),
            'remember_token' => Auth::viaRemember()
        ));
        Employee::create(array(
            'lastname' => 'L',
            'firstname' => 'Marcel',
            'birthday' => Carbon::createFromDate(1995, 6, 28),
            'phone' => '123/456',
            'mobile' => '456/7890',
            'email' => 'scrat007@gmx.de',
            'address_id' => 2,
            'role_id' => 2,
            'password' => Hash::make('awesome'),
            'remember_token' => Auth::viaRemember()
        ));
    }

}