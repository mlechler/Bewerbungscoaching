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

    {{ Form::submit($freetime->exists ? 'Save Free Timne' : 'Create New Free Time', ['class' => 'btn btn-success']) }}
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
            showClear: true
        });
        $('input[name=endtime]').datetimepicker({
            allowInputToggle: true,
            format: 'HH:mm',
            showClear: true
        });
    </script>
@endsection