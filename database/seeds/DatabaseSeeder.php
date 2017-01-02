<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('EmployeeTableSeeder');
        $this->call('MemberTableSeeder');
        $this->call('SeminarTableSeeder');
        $this->call('PageTableSeeder');
        $this->call('PostTableSeeder');
        $this->call('AdressTableSeeder');
        $this->call('RoleTableSeeder');
    }
}
