<?php

use Illuminate\Database\Seeder;
use App\Discount;
use Carbon\Carbon;

class DiscountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounts')->truncate();
        Discount::create(array(
            'title' => 'Discount 1',
            'amount' => 199,
            'percentage' => false,
            'service' => 'Universal',
            'validity' => 20,
            'permanent' => 0,
            'startdate' => Carbon::createFromDate(2017,5,23),
            'code' => 'Code199',
            'expired' => 0,
        ));
        Discount::create(array(
            'title' => 'Discount 2',
            'amount' => 15,
            'percentage' => true,
            'service' => 'Individual Coaching',
            'validity' => null,
            'permanent' => 1,
            'startdate' => Carbon::createFromDate(2017,5,23),
            'code' => 'Coaching15',
            'expired' => 0,
        ));
        Discount::create(array(
            'title' => 'Discount 3',
            'amount' => 50,
            'percentage' => true,
            'service' => 'Universal',
            'validity' => null,
            'permanent' => 1,
            'startdate' => Carbon::createFromDate(2017,5,23),
            'code' => 'Universal50',
            'expired' => 0,
        ));
    }
}
