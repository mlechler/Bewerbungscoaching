<?php

use Illuminate\Database\Seeder;
use App\Page;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->delete();
        Page::create(array(
            'title' => 'About',
            'uri' => 'about',
            'pagecontent' => 'This is the about page.'
        ));
        Page::create(array(
            'title' => 'Contact',
            'uri' => 'contact',
            'pagecontent' => 'This is the contact page.'
        ));
        Page::create(array(
            'title' => 'FAQ',
            'uri' => 'faq',
            'pagecontent' => 'This is the FAQ page.'
        ));
    }
}
