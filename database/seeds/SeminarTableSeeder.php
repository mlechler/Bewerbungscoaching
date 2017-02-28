<?php

use Illuminate\Database\Seeder;
use App\Seminar;

class SeminarTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('seminars')->truncate();
        Seminar::create(array(
            'title' => 'Seminar 1',
            'description' => 'This is the best seminar ever!',
            'services' => 'Catering',
            'maxMembers' => 12,
            'duration' => 6,
            'price' => 99
        ));
        Seminar::create(array(
            'title' => 'Seminar 2',
            'description' => 'This is even better!',
            'services' => 'Catering, Document Review',
            'maxMembers' => 12,
            'duration' => 6,
            'price' => 199
        ));
    }
}
