<?php

namespace App\Http\Controllers\Backend;

use App\Task;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    protected $tasks;

    public function __construct(Task $tasks)
    {
        $this->tasks = $tasks;

        parent::__construct();
    }

    public function index()
    {
        $tasks = Task::with('creator')->where('employee_id', '=', null)->orWhere('employee_id', '=', Auth::guard('employee')->id())->orderBy('finished')->orderBy('processing')->paginate(10);

        return view('backend.todo.index', compact('tasks'));
    }

    public function create(Task $task)
    {
        return view('backend.todo.form', compact('task'));
    }

    public function store(Requests\Backend\StoreTaskRequest $request)
    {
        Task::create(array(
            'creator_id' => Auth::guard('employee')->id(),
            'title' => $request->title,
            'description' => $request->description,
            'processing' => false,
            'processedby' => null,
            'finished' => false
        ));

        return redirect(route('todo.index'))->with('status', 'Task has been created.');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);

        return view('backend.todo.form', compact('task'));
    }

    public function update(Requests\Backend\UpdateTaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->fill(array(
            'title' => $request->title,
            'description' => $request->description,
            'finished' => false
        ))->save();

        return redirect(route('todo.index'))->with('status', 'Task has been updated.');
    }

    public function confirm($id)
    {
        $task = Task::findOrFail($id);

        return view('backend.todo.confirm', compact('task'));
    }

    public function destroy($id)
    {
        Task::destroy($id);

        return redirect(route('todo.index'))->with('status', 'Task has been deleted.');
    }

    public function detail($id)
    {
        $task = Task::with('creator', 'processor')->findOrFail($id);

        return view('backend.todo.detail', compact('task'));
    }

    public function taskFinished($id)
    {
        $task = Task::findOrFail($id);

        if ((Auth::guard('employee')->user()->isAdmin() || $task->processedby == Auth::guard('employee')->id()) && !$task->finished) {
            $task->fill(array(
                'processing' => false,
                'finished' => true
            ))->save();

            return redirect()->back()->with('status', 'Task has been closed.');
        }
        return redirect()->back();
    }

    public function taskProcessing($id)
    {
        $task = Task::findOrFail($id);

        if ((Auth::guard('employee')->user()->isAdmin() || !$task->processing) && !$task->finished) {
            $task->fill(array(
                'processing' => true,
                'processedby' => Auth::guard('employee')->id()
            ))->save();

            return redirect()->back()->with('status', 'Task is now in your processing.');
        }
        return redirect()->back();
    }

    public function deleteAllFinishedTasks()
    {
        $tasks = Task::all()->where('finished', '=', true);

        if (!$tasks->isEmpty()) {
            foreach ($tasks as $task) {
                Task::destroy($task->id);
            }

            return redirect(route('todo.index'))->with('status', 'Tasks have been deleted.');

        } else {
            return redirect(route('todo.index'))->withErrors([
                'error' => 'No finished Tasks.'
            ]);
        }

    }
}