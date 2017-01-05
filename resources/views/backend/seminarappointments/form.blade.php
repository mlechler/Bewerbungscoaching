@extends('layouts.backend')

@section('title', $seminarappointment->exists ? 'Editing VALUE' : 'Create New Appointment')

@section('content')
    {{ Form::model($seminarappointment, [
    'method' => $seminarappointment->exists ? 'put' : 'post',
    'route' => $seminarappointment->exists ? ['seminarappointments.update', $seminarappointment->id] :['seminarappointments.store'],
    'enctype' => 'multipart/form-data'
    ]) }}

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('seminar') }}
            {{ Form::select('seminar_id', $seminars, null, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('employee') }}
            {{ Form::select('employee_id', $employees, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('date') }}
        {{ Form::text('date', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('start_time') }}
        {{ Form::text('time', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            {{ Form::label('zip_code') }}
            {{ Form::text('zip', $seminarappointment->adress ? $seminarappointment->adress->zip : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('city') }}
            {{ Form::text('city', $seminarappointment->adress ? $seminarappointment->adress->city : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('street') }}
            {{ Form::text('street', $seminarappointment->adress ? $seminarappointment->adress->street : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-2">
            {{ Form::label('housenumber') }}
            {{ Form::text('housenumber', $seminarappointment->adress ? $seminarappointment->adress->housenumber : null, ['class' => 'form-control']) }}
        </div>
    </div>

    {{ Form::submit($seminarappointment->exists ? 'Save Appointment' : 'Create New Appointment', ['class' => 'btn btn-success']) }}
    <a href="{{ route('seminarappointments.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        $('input[name=date]').datetimepicker({
            allowInputToggle: true,
            format: 'YYYY-MM-DD',
            showClear: true,
            defaultDate: '{{ old('date', $seminarappointment->date) }}'
        });
        $('input[name=time]').datetimepicker({
            allowInputToggle: true,
            format: 'HH:mm',
            showClear: true
        });
    </script>
@endsection