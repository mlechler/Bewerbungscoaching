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
        DB::table('pages')->truncate();
        Page::create(array(
            'title' => 'About',
            'uri' => 'about',
            'pagecontent' => 'This is the about page.',
            'parent_id' => null,
            'lft' => 3,
            'rgt' => 6,
            'depth' => 0
        ));
        Page::create(array(
            'title' => 'Contact',
            'uri' => 'contact',
            'pagecontent' => 'This is the contact page.',
            'parent_id' => 1,
            'lft' => 4,
            'rgt' => 5,
            'depth' => 1
        ));
        Page::create(array(
            'title' => 'FAQ',
            'uri' => 'faq',
            'pagecontent' => 'This is the FAQ page.',
            'parent_id' => null,
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0
        ));
    }
}
