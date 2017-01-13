<?php

use Illuminate\Database\Seeder;
use App\Individualcoaching;
use Carbon\Carbon;

class IndividualcoachingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('individualcoachings')->truncate();
        Individualcoaching::create(array(
            'services' => 'Interview, Document Review',
            'date' => Carbon::createFromDate(2017, 01, 05),
            'time' => Carbon::createFromTime(9, 00, 00),
            'duration' => 10,
            'price' => 99,
            'trial' => false,
            'paid' => true,
            'employee_id' => 1,
            'member_id' => 1
        ));
        Individualcoaching::create(array(
            'services' => 'Interview',
            'date' => Carbon::createFromDate(2017, 01, 05),
            'time' => Carbon::createFromTime(9, 00, 00),
            'duration' => 1,
            'price' => 0,
            'trial' => true,
            'paid' => true,
            'employee_id' => 1,
            'member_id' => 2
        ));
    }
}
