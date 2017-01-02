<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        Role::create(array(
            'name' => 'admin',
            'display_name' => 'Admin'
        ));
        Role::create(array(
            'name' => 'employee',
            'display_name' => 'Employee'
        ));
        Role::create(array(
            'name' => 'member',
            'display_name' => 'Member'
        ));
    }
}
