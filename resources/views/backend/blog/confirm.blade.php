@extends('layouts.backend')

@section('title', 'Deleting '.$post->title)

@section('content')
    {{ Form::open([
    'method' => 'delete',
    'route' => ['blog.destroy', $post->id]
    ]) }}

    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete a Blog Post. All Files and Informations belonging to this Blog Post will be deleted. This action cannot be undone.
        <br>
        Are you sure you want to continue?
    </div>

    {{ Form::submit('Yes, delete this blog post!', ['class' => 'btn btn-danger']) }}
    <a href="{{ route('blog.index') }}" class="btn btn-success">
        <strong>No, get me out of here!</strong>
    </a>

    {{ Form::close() }}
@endsection