@extends('layouts.backend')

@section('title', 'Deleting ')

@section('content')
    {{ Form::open([
    'method' => 'delete',
    'route' => ['seminarappointments.destroy', $seminarappointment->id]
    ]) }}

    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete an appointment. This action cannot be undone. Are you sure you
        want to continue?
    </div>

    {{ Form::submit('Yes, delete this appointment!', ['class' => 'btn btn-danger']) }}
    <a href="{{ route('seminarappointments.index') }}" class="btn btn-success">
        <strong>No, get me out of here!</strong>
    </a>

    {{ Form::close() }}
@endsection