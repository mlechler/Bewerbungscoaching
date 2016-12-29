@extends('layouts.backend')

@section('title', $employee->exists ? 'Editing '.$employee->getName() : 'Create New Employee')

@section('content')
    {{ Form::model($employee, [
    'method' => $employee->exists ? 'put' : 'post',
    'route' => $employee->exists ? ['employees.update', $employee->id] :['employees.store']
    ]) }}

    <div class="form-group">
        {{ Form::label('lastname') }}
        {{ Form::text('lastname', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('firstname') }}
        {{ Form::text('firstname', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('birthday') }}
        {{ Form::text('birthday', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('phone') }}
        {{ Form::text('phone', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('mobile') }}
        {{ Form::text('mobile', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('email') }}
        {{ Form::text('email', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('password') }}
        {{ Form::password('password', ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('password_confirmation') }}
        {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
    </div>

    {{ Form::submit($employee->exists ? 'Save Employee' : 'Create New Employee', ['class' => 'btn btn-success']) }}
    <a href="/admin/employees" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}
@endsection