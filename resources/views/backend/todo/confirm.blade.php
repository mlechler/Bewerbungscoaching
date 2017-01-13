@extends('layouts.backend')

@section('title', 'Deleting '.$task->title)

@section('content')
    {{ Form::open([
    'method' => 'delete',
    'route' => ['todo.destroy', $task->id]
    ]) }}

    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete a task. This action cannot be undone. Are you sure you
        want to continue?
    </div>

    {{ Form::submit('Yes, delete this task!', ['class' => 'btn btn-danger']) }}
    <a href="{{ route('todo.index') }}" class="btn btn-success">
        <strong>No, get me out of here!</strong>
    </a>

    {{ Form::close() }}
@endsection