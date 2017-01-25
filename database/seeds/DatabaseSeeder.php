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
        $this->call('AddressTableSeeder');
        $this->call('RoleTableSeeder');
        $this->call('AppointmentTableSeeder');
        $this->call('BookingTableSeeder');
        $this->call('IndividualCoachingTableSeeder');
        $this->call('TaskTableSeeder');
        $this->call('DiscountTableSeeder');
        $this->call('InvoiceTableSeeder');
        $this->call('PackageTableSeeder');
        $this->call('LayoutTableSeeder');
    }
}
