@extends('layouts.backend')

@section('title', 'Tasks')

@section('content')
    <a href="{{ route('todo.create') }}" class="btn btn-primary">Create New Task</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Creator</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($tasks->isEmpty())
            <tr>
                <td colspan="6" align="center">There are no tasks.</td>
            </tr>
        @else
            @foreach($tasks as $task)
                <tr class="{{ $task->finishedHighlight() }}">
                    <td>
                        {{ $task->title }}
                    </td>
                    <td>
                        {{ $task->getShortDescription($task->description) }}
                    </td>
                    <td>
                        {{ $task->creator->getName() }}
                    </td>
                    <td>
                        <a href="/backend/todo/<?php echo $task->id ?>/detail"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
                    </td>
                    <td>
                        <a href="/backend/todo/<?php echo $task->id ?>/edit"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/backend/todo/<?php echo $task->id ?>/confirm"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $tasks->links() }}
@endsection