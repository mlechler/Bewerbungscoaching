@extends('layouts.backend')

@section('title', $freetime->exists ? 'Editing VALUE' : 'Create New Free Time')

@section('content')
    {{ Form::model($freetime, [
    'method' => $freetime->exists ? 'put' : 'post',
    'route' => $freetime->exists ? ['employeefreetimes.update', $freetime->id] :['employeefreetimes.store']
    ]) }}

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('employee') }}
            {{ Form::select('employee_id', $employees, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('date') }}
            {{ Form::text('date', null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('start_time') }}
            {{ Form::text('starttime', null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('end_time') }}
            {{ Form::text('endtime', null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('hourly_rate') }}
            {{ Form::number('hourlyrate', null, ['class' => 'form-control', 'min' => 0, 'step' => 1]) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('services') }}
            {{ Form::text('services', null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            {{ Form::label('zip_code') }}
            {{ Form::text('zip', $freetime->address ? $freetime->address->zip : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('city') }}
            {{ Form::text('city', $freetime->address ? $freetime->address->city : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('street') }}
            {{ Form::text('street', $freetime->address ? $freetime->address->street : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-2">
            {{ Form::label('housenumber') }}
            {{ Form::text('housenumber', $freetime->address ? $freetime->address->housenumber : null, ['class' => 'form-control']) }}
        </div>
    </div>

    {{ Form::submit($freetime->exists ? 'Save Free Time' : 'Create New Free Time', ['class' => 'btn btn-success']) }}
    <a href="{{ route('employeefreetimes.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        $('input[name=date]').datetimepicker({
            allowInputToggle: true,
            format: 'YYYY-MM-DD',
            showClear: true,
            defaultDate: '{{ old('date', $freetime->date) }}'
        });
        $('input[name=starttime]').datetimepicker({
            allowInputToggle: true,
            format: 'HH:mm',
            stepping: 30,
            showClear: true
        });
        $('input[name=endtime]').datetimepicker({
            allowInputToggle: true,
            format: 'HH:mm',
            stepping: 30,
            showClear: true
        });
    </script>
@endsection