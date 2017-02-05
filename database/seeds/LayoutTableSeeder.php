<?php

use Illuminate\Database\Seeder;
use App\ApplicationLayout;

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
        ApplicationLayout::create(array(
            'title' => 'Layout 1',
            'description' => 'This is Layout 1!',
            'price' => 19.99
        ));
        ApplicationLayout::create(array(
            'title' => 'Layout 2',
            'description' => 'This is Layout 2!',
            'price' => 19.99
        ));
        ApplicationLayout::create(array(
            'title' => 'Layout 3',
            'description' => 'This is Layout 3!',
            'price' => 19.99
        ));
    }
}
