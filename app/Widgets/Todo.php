<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Task;

class Todo extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $tasks = Task::where('finished', '=', false)->where('processing','=',false)->orderBy('created_at')->take(5)->get();

        return view("backend.widgets.todo", [
            'config' => [],
        ], compact('tasks'));
    }
}