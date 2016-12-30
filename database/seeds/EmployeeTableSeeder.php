<?php

use Illuminate\Database\Seeder;
use App\Employee;

class EmployeeTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('employees')->truncate();
        Employee::create(array(
            'lastname' => 'Lechler',
            'firstname' => 'Marcel',
            'birthday' => '28.06.1995',
            'phone' => '123/456',
            'mobile' => '456/789',
            'email' => 'marcel.lechler@gmx.de',
            'password' => Hash::make('awesome'),
            'remember_token' => Auth::viaRemember()
        ));
        Employee::create(array(
            'lastname' => 'L',
            'firstname' => 'Marcel',
            'birthday' => '28.06.1995',
            'phone' => '123/456',
            'mobile' => '456/7890',
            'email' => 'scrat007@gmx.de',
            'password' => Hash::make('awesome'),
            'remember_token' => Auth::viaRemember()
        ));
    }

}