@extends('layouts.backend')

@section('title', $memberdiscount->exists ? 'Editing VALUE' : 'Create New Memberdiscount')

@section('content')
    {{ Form::model($memberdiscount, [
    'method' => $memberdiscount->exists ? 'put' : 'post',
    'route' => $memberdiscount->exists ? ['memberdiscounts.update', $memberdiscount->id] :['memberdiscounts.store']
    ]) }}

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('member') }}
            {{ Form::select('member_id', $members, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('discount') }}
            {{ Form::select('discount_id', $discounts, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('validity') }}
        {{ Form::number('validity', null, ['class' => 'form-control', 'min' => 0]) }}
    </div>

    <div class="form-group">
        {{ Form::label('start_date') }}
        {{ Form::text('startdate', null, ['class' => 'form-control']) }}
    </div>

    {{ Form::submit($memberdiscount->exists ? 'Save Memberdiscount' : 'Create New Memberdiscount', ['class' => 'btn btn-success']) }}
    <a href="{{ route('discounts.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        $('input[name=startdate]').datetimepicker({
            allowInputToggle: true,
            format: 'YYYY-MM-DD',
            showClear: true,
            defaultDate: '{{ old('startdate', $memberdiscount->startdate) }}'
        });
    </script>
@endsection