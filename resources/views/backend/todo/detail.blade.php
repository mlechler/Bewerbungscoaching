@extends('layouts.backend')

@section('title', 'Details of '.$task->title)

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Title</h4>
            </td>
            <td>
                <h4>{{ $task->title }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Creator</h4>
            </td>
            <td>
                <h4>{{ $task->getName() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Employee</h4>
            </td>
            <td>
                @if($task->employee_id)
                    <h4>{{ $task->employee->getName() }}</h4>
                @else
                    <h4>All</h4>
                @endif
            </td>
        </tr>
        <tr>
            <td>
                <h4>Description</h4>
            </td>
            <td>
                <h4>{!! $task->descriptionHtml() !!}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>In Processing</h4>
            </td>
            <td>
                <h4>
                    <span class="glyphicon glyphicon-{{ $task->processing ? 'ok' : 'remove'}}"></span> {{ $task->processing ? ' by ' . $task->processedBy() : null}}
                </h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Finished</h4>
            </td>
            <td>
                <h4><span class="glyphicon glyphicon-{{ $task->finished ? 'ok' : 'remove'}}"></span></h4>
            </td>
        </tr>
        </tbody>
    </table>
    @if (!$task->processing && !$task->finished)
        <a href="{{ route('todo.processTask', $task->id) }}" class="btn btn-warning">Process Task</a>
    @endif
    @if(!$task->finished)
        <a href="{{ route('todo.finishedTask', $task->id) }}" class="btn btn-success">Task is finished</a>
    @endif
    <a href="{{ route('todo.index') }}" class="btn btn-danger">Back</a>
@endsection