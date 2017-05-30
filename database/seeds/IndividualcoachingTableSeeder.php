<?php

use Illuminate\Database\Seeder;
use App\IndividualCoaching;
use Carbon\Carbon;

class IndividualCoachingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('individualcoachings')->truncate();
        IndividualCoaching::create(array(
            'services' => 'Interview, Document Review',
            'date' => Carbon::createFromDate(2017, 07, 05),
            'time' => Carbon::createFromTime(9, 00, 00),
            'duration' => 10,
            'price_incl_discount' => 99,
            'trial' => false,
            'paid' => true,
            'employee_id' => 1,
            'member_id' => 1,
            'address_id' => 1,
            'reminderSend' => false
        ));
        IndividualCoaching::create(array(
            'services' => 'Interview',
            'date' => Carbon::createFromDate(2017, 07, 05),
            'time' => Carbon::createFromTime(9, 00, 00),
            'duration' => 1,
            'price_incl_discount' => 0,
            'trial' => true,
            'paid' => true,
            'employee_id' => 1,
            'member_id' => 2,
            'address_id' => 2,
            'reminderSend' => false
        ));
    }
}
