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
            {{ Form::label('seminar') }} <span class="required">*</span>
            {{ Form::select('seminar_id', $seminars, null, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('employee') }} <span class="required">*</span>
            {{ Form::select('employee_id', $employees, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('date') }} <span class="required">*</span>
        {{ Form::text('date', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('start_time') }} <span class="required">*</span>
        {{ Form::text('time', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            {{ Form::label('zip_code') }} <span class="required">*</span>
            {{ Form::text('zip', $seminarappointment->address ? $seminarappointment->address->zip : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('city') }} <span class="required">*</span>
            {{ Form::text('city', $seminarappointment->address ? $seminarappointment->address->city : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('street') }} <span class="required">*</span>
            {{ Form::text('street', $seminarappointment->address ? $seminarappointment->address->street : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-2">
            {{ Form::label('housenumber') }} <span class="required">*</span>
            {{ Form::text('housenumber', $seminarappointment->address ? $seminarappointment->address->housenumber : null, ['class' => 'form-control']) }}
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