@extends('layouts.backend')

@section('title', $coaching->exists ? 'Editing VALUE' : 'Create new Coaching')

@section('content')
    {{ Form::model($coaching, [
    'method' => $coaching->exists ? 'put' : 'post',
    'route' => $coaching->exists ? ['individualcoachings.update', $coaching->id] :['individualcoachings.store']
    ]) }}

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('employee') }}
            {{ Form::select('employee_id', $employees, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('member') }}
            {{ Form::select('member_id', $members, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('services') }}
        {{ Form::text('services', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('date') }}
        {{ Form::text('date', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('start_time') }}
        {{ Form::text('time', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('duration') }}
        {{ Form::number('duration', null, ['class' => 'form-control', 'step' => '0.5']) }}
    </div>

    <div class="form-group">
        {{ Form::label('price') }}
        {{ Form::number('price', null, ['class' => 'form-control', 'step' => '0.01']) }}
    </div>

    <div class="form-group">
        {{ Form::label('trial') }}
        {{ Form::checkbox('trial', null) }}
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
                document.getElementById('price').value = 0;
                document.getElementById('duration').value = 1;
            }
        });
    </script>
@endsection