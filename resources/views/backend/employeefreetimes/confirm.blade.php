@extends('layouts.backend')

@section('title', 'Deleting VALUE')

@section('content')
    {{ Form::open([
    'method' => 'delete',
    'route' => ['employeefreetimes.destroy', $freetime->id]
    ]) }}

    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete an Employee Free Time. All Files and Informations belonging to this Employee will be deleted. This action cannot be undone.
        <br>
        Are you sure you want to continue?
    </div>

    {{ Form::submit('Yes, delete this employee free time!', ['class' => 'btn btn-danger']) }}
    <a href="{{ route('employeefreetimes.index') }}" class="btn btn-success">
        <strong>No, get me out of here!</strong>
    </a>

    {{ Form::close() }}
@endsection
