<?php

use App\Booking;
use Illuminate\Database\Seeder;

class BookingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seminarbookings')->truncate();
        Booking::create(array(
            'member_id' => 1,
            'appointment_id' => 1,
            'price_incl_discount' => 123.45,
            'paid' => false,
            'reminderSend' => false
        ));
        Booking::create(array(
            'member_id' => 2,
            'appointment_id' => 2,
            'price_incl_discount' => 99.99,
            'paid' => true,
            'reminderSend' => false
        ));
    }
}
