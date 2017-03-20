@extends('layouts.backend')

@section('title', $coaching->exists ? 'Editing VALUE' : 'Create new Coaching')

@section('content')
    {{ Form::model($coaching, [
    'method' => $coaching->exists ? 'put' : 'post',
    'route' => $coaching->exists ? ['individualcoachings.update', $coaching->id] :['individualcoachings.store']
    ]) }}

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('employee') }} <span class="required">*</span>
            {{ Form::select('employee_id', $employees, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('member') }} <span class="required">*</span>
            {{ Form::select('member_id', $members, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('services') }} <span class="required">*</span>
        {{ Form::text('services', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('date') }} <span class="required">*</span>
        {{ Form::text('date', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('start_time') }} <span class="required">*</span>
        {{ Form::text('time', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('duration') }} <span class="required">*</span>
        {{ Form::number('duration', null, ['class' => 'form-control', 'id' => 'duration', 'step' => '0.5', 'min' => 0]) }}
    </div>

    <div class="form-group">
        {{ Form::label('price_inclusive_discount') }} <span class="required">*</span>
        {{ Form::number('price_incl_discount', null, ['class' => 'form-control', 'id' => 'price_incl_discount', 'step' => '0.01', 'min' => 0]) }}
    </div>

    <div class="form-group">
        {{ Form::label('trial') }}
        {{ Form::checkbox('trial', null) }}
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            {{ Form::label('zip_code') }} <span class="required">*</span>
            {{ Form::text('zip', $coaching->address ? $coaching->address->zip : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('city') }} <span class="required">*</span>
            {{ Form::text('city', $coaching->address ? $coaching->address->city : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('street') }} <span class="required">*</span>
            {{ Form::text('street', $coaching->address ? $coaching->address->street : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-2">
            {{ Form::label('housenumber') }} <span class="required">*</span>
            {{ Form::text('housenumber', $coaching->address ? $coaching->address->housenumber : null, ['class' => 'form-control']) }}
        </div>
    </div>

    {{ Form::submit($coaching->exists ? 'Save Coaching' : 'Create new Coaching', ['class' => 'btn btn-success']) }}
    <a href="{{ route('individualcoachings.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        $('input[name=date]').datetimepicker({
            allowInputToggle: true,
            format: 'YYYY-MM-DD',
            showClear: true,
            defaultDate: '{{ old('date', $coaching->date) }}'
        });
        $('input[name=time]').datetimepicker({
            allowInputToggle: true,
            format: 'HH:mm',
            showClear: true
        });
        $('#trial').on('change', function () {
            if ($(this).is(':checked')) {
                document.getElementById('price_incl_discount').value = 0;
                document.getElementById('duration').value = 1;
            }
        });
    </script>
@endsection