@extends('layouts.backend')

@section('title', $employee->exists ? 'Editing '.$employee->getName() : 'Create New Employee')

@section('content')
    {{ Form::model($employee, [
    'method' => $employee->exists ? 'put' : 'post',
    'route' => $employee->exists ? ['employees.update', $employee->id] :['employees.store'],
    'enctype' => 'multipart/form-data'
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

    <div class="form-group row">
        <div class="col-md-2">
            {{ Form::label('zip_code') }}
            {{ Form::text('zip', $adress ? $adress->zip : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('city') }}
            {{ Form::text('city', $adress ? $adress->city : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('street') }}
            {{ Form::text('street', $adress ? $adress->street : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-2">
            {{ Form::label('housenumber') }}
            {{ Form::text('housenumber', $adress ? $adress->housenumber : null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('role') }}
        </div>
        <div class="col-md-4">
            {{ Form::select('role_id', $roles, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('password') }}
        {{ Form::password('password', ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('password_confirmation') }}
        {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('files') }}
            <br>
            @if($files != null)
                @foreach($files as $file)
                    {{ $file }}
                    <br>
                @endforeach
            @endif
        </div>
        <div class="col-md-5">
            <br>
            {{ Form::file('file', null, ['class' => 'form-control']) }}
        </div>
    </div>

    {{ Form::submit($employee->exists ? 'Save Employee' : 'Create New Employee', ['class' => 'btn btn-success']) }}
    <a href="{{ route('employees.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        $('input[name=birthday]').datetimepicker({
            allowInputToggle: true,
            format: 'YYYY-MM-DD',
            showClear: true,
            defaultDate: '{{ old('birthday', $employee->birthday) }}'
        });
    </script>
@endsection