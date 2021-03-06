@extends('layouts.backend')

@section('title', 'Deleting '.$member->getName())

@section('content')
    {{ Form::open([
    'method' => 'delete',
    'route' => ['members.destroy', $member->id]
    ]) }}

    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete a Member. All Files and Informations belonging to this Member will be deleted. This action cannot be undone.
        <br>
        Are you sure you want to continue?
    </div>

    {{ Form::submit('Yes, delete this Member!', ['class' => 'btn btn-danger']) }}
    <a href="{{ route('members.index') }}" class="btn btn-success">
        <strong>No, get me out of here!</strong>
    </a>

    {{ Form::close() }}
@endsection