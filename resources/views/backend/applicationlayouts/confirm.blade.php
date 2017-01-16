@extends('layouts.backend')

@section('title', 'Deleting '.$layout->title)

@section('content')
    {{ Form::open([
    'method' => 'delete',
    'route' => ['applicationlayouts.destroy', $layout->id]
    ]) }}

    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete an application layout. This action cannot be undone. Are you sure you
        want to continue?
    </div>

    {{ Form::submit('Yes, delete this application layout!', ['class' => 'btn btn-danger']) }}
    <a href="{{ route('applicationlayouts.index') }}" class="btn btn-success">
        <strong>No, get me out of here!</strong>
    </a>

    {{ Form::close() }}
@endsection