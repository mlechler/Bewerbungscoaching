<?php

use Illuminate\Database\Seeder;
use App\Discount;

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
            'service' => 'Universal'
        ));
        Discount::create(array(
            'title' => 'Discount 2',
            'amount' => 15,
            'percentage' => true,
            'service' => 'Individual Coaching'
        ));
        Discount::create(array(
            'title' => 'Discount 3',
            'amount' => 50,
            'percentage' => true,
            'service' => 'Universal'
        ));
    }
}
