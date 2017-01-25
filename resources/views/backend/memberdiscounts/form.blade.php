@extends('layouts.backend')

@section('title', $memberdiscount->exists ? 'Editing VALUE' : 'Create New Member Discount')

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

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('validity') }}
            {{ Form::number('validity', null, ['class' => 'form-control', 'min' => 0]) }}
        </div>
        <div class="col-md-1">
            {{ Form::label('permanent') }}
            {{ Form::checkbox('permanent', null) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('start_date') }}
        {{ Form::text('startdate', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('code') }}
        </div>
        <div class="col-md-12">
            <div class="input-group">
                {{ Form::text('code', null, ['class' => 'form-control']) }}
                <span class="input-group-btn">{{ Form::button('Random Code', ['class' => 'btn btn-default', 'onclick' => 'getCode()', 'style' => 'height: 34px']) }}</span>
            </div>
        </div>
    </div>

    {{ Form::submit($memberdiscount->exists ? 'Save Member Discount' : 'Create New Member Discount', ['class' => 'btn btn-success']) }}
    <a href="{{ route('memberdiscounts.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('permanent').checked) {
                document.getElementById('validity').disabled = true;
            }
        }, false);

        $('input[name=startdate]').datetimepicker({
            allowInputToggle: true,
            format: 'YYYY-MM-DD',
            showClear: true,
            defaultDate: '{{ old('startdate', $memberdiscount->startdate) }}'
        });
        $('#permanent').on('change', function () {
            if ($(this).is(':checked')) {
                document.getElementById('validity').disabled = true;
            } else {
                document.getElementById('validity').disabled = false;
            }
        });
        function getCode() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < 12; i++) {
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            }

            document.getElementById('code').value = text;
        }
    </script>
@endsection