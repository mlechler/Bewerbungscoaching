@extends('layouts.backend')

@section('title', 'Deleting '.$page->title)

@section('content')
    {{ Form::open([
    'method' => 'delete',
    'route' => ['pages.destroy', $page->id]
    ]) }}

    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete a Page. All Files and Informations belonging to this Page will be deleted. This action cannot be undone.
        <br>
        Are you sure you want to continue?
    </div>

    {{ Form::submit('Yes, delete this Page!', ['class' => 'btn btn-danger']) }}
    <a href="{{ route('pages.index') }}" class="btn btn-success">
        <strong>No, get me out of here!</strong>
    </a>

    {{ Form::close() }}
@endsection