@extends('layouts.backend')

@section('title', 'Deleting '.$employee->getName())

@section('content')
    {{ Form::open([
    'method' => 'delete',
    'route' => ['employees.destroy', $employee->id]
    ]) }}

    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete a employee. This action cannot be undone. Are you sure you
        want to continue?
    </div>

    {{ Form::submit('Yes, delete this employee!', ['class' => 'btn btn-danger']) }}
    <a href="/admin/employees" class="btn btn-success">
        <strong>No, get me out of here!</strong>
    </a>

    {{ Form::close() }}
@endsection
