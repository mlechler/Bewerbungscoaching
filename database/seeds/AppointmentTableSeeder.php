<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Appointment;

class AppointmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seminarappointments')->truncate();
        Appointment::create(array(
            'date' => Carbon::createFromDate(2017, 03, 05),
            'time' => Carbon::createFromTime(9, 00, 00),
            'employee_id' => 1,
            'seminar_id' => 1,
            'address_id' => 1,
        ));
        Appointment::create(array(
            'date' => Carbon::createFromDate(2017, 03, 05),
            'time' => Carbon::createFromTime(18, 30, 00),
            'employee_id' => 2,
            'seminar_id' => 2,
            'address_id' => 2,
        ));
    }
}
