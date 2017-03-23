@extends('layouts.backend')

@section('title', $task->exists ? 'Editing '.$task->title : 'Create New Task')

@section('content')
    {{ Form::model($task, [
    'method' => $task->exists ? 'put' : 'post',
    'route' => $task->exists ? ['todo.update', $task->id] :['todo.store']
    ]) }}

    <div class="form-group">
        {{ Form::label('title') }} <span class="required">*</span>
        {{ Form::text('title', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('description') }} <span class="required">*</span>
        {{ Form::textarea('description', null, ['class' => 'form-control']) }}
    </div>

    {{ Form::submit($task->exists ? 'Save Task' : 'Create New Task', ['class' => 'btn btn-success']) }}
    <a href="{{ route('todo.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        new SimpleMDE({
            toolbar: ["bold", "italic", "strikethrough", "heading", "|", "code", "quote", "unordered-list", "ordered-list",
                "clean-block", "|", "link", "image", "table", "horizontal-rule", "|", "preview", "side-by-side", "fullscreen", "|", "guide"]
        }).render();
    </script>
@endsection