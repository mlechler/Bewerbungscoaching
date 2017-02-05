@extends('layouts.backend')

@section('title', $task->exists ? 'Editing '.$task->title : 'Create New Task')

@section('content')
    {{ Form::model($task, [
    'method' => $task->exists ? 'put' : 'post',
    'route' => $task->exists ? ['todo.update', $task->id] :['todo.store']
    ]) }}

    <div class="form-group">
        {{ Form::label('title') }}
        {{ Form::text('title', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('description') }}
        {{ Form::textarea('description', null, ['class' => 'form-control']) }}
    </div>

    {{ Form::submit($task->exists ? 'Save Task' : 'Create New Task', ['class' => 'btn btn-success']) }}
    <a href="{{ route('todo.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        new SimpleMDE().render();
    </script>
@endsection