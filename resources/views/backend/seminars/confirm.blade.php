@extends('layouts.backend')

@section('title', 'Deleting '.$seminar->title)

@section('content')
    {{ Form::open([
    'method' => 'delete',
    'route' => ['seminars.destroy', $seminar->id]
    ]) }}

    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete a Seminar. All Files and Informations belonging to this Seminar will be deleted. This action cannot be undone.
        <br>
        Are you sure you want to continue?
    </div>

    {{ Form::submit('Yes, delete this Seminar!', ['class' => 'btn btn-danger']) }}
    <a href="{{ route('seminars.index') }}" class="btn btn-success">
        <strong>No, get me out of here!</strong>
    </a>

    {{ Form::close() }}
@endsection