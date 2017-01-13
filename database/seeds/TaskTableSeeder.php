<?php

use Illuminate\Database\Seeder;
use App\Task;

class TaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->truncate();
        Task::create(array(
            'title' => 'Task 1',
            'description' => 'This is Task 1',
            'creator_id' => 1,
            'finished' => false
        ));
        Task::create(array(
            'title' => 'Task 2',
            'description' => 'This is Task 2',
            'creator_id' => 1,
            'finished' => false
        ));
        Task::create(array(
            'title' => 'Task 3',
            'description' => 'This is Task 3',
            'creator_id' => 2,
            'finished' => true
        ));
    }
}
