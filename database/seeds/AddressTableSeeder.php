<?php

use Illuminate\Database\Seeder;
use App\Address;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('addresses')->truncate();
        Address::create(array(
            'zip' => 71263,
            'city' => 'Weil der Stadt',
            'street' => 'Hauptstraße',
            'housenumber' => '13',
            'latitude' => '48.76781',
            'longitude' => '8.85230'
        ));
        Address::create(array(
            'zip' => 71034,
            'city' => 'Böblingen',
            'street' => 'Herrenberger Straße',
            'housenumber' => '140',
            'latitude' => '48.67585',
            'longitude' => '8.97656'
        ));
    }
}