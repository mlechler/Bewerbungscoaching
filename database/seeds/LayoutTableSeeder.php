<?php

use Illuminate\Database\Seeder;
use App\Applicationlayout;

class LayoutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('applicationlayouts')->truncate();
        Applicationlayout::create(array(
            'title' => 'Layout 1',
            'description' => 'This is Layout 1!',
            'price' => 19.99
        ));
        Applicationlayout::create(array(
            'title' => 'Layout 2',
            'description' => 'This is Layout 2!',
            'price' => 19.99
        ));
        Applicationlayout::create(array(
            'title' => 'Layout 3',
            'description' => 'This is Layout 3!',
            'price' => 19.99
        ));
    }
}
