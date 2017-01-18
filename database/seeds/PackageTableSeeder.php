<?php

use Illuminate\Database\Seeder;
use App\Applicationpackage;

class PackageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('applicationpackages')->truncate();
        Applicationpackage::create(array(
            'title' => 'Package 1',
            'description' => 'This is Package 1!',
            'price' => 19.99
        ));
        Applicationpackage::create(array(
            'title' => 'Package 2',
            'description' => 'This is Package 2!',
            'price' => 29.99
        ));
    }
}
