<?php

use Illuminate\Database\Seeder;
use App\Adress;

class AdressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('adresses')->truncate();
        Adress::create(array(
            'zip' => 71263,
            'city' => 'Weil der Stadt',
            'street' => 'Hauptstraße',
            'housenumber' => '13'
        ));
        Adress::create(array(
            'zip' => 71034,
            'city' => 'Böblingen',
            'street' => 'Nebenstraße',
            'housenumber' => '25/1'
        ));
    }
}
