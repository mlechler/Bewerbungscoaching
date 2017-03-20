@extends('layouts.backend')

@section('title', $discount->exists ? 'Editing '.$discount->title : 'Create New Discount')

@section('content')
    {{ Form::model($discount, [
    'method' => $discount->exists ? 'put' : 'post',
    'route' => $discount->exists ? ['discounts.update', $discount->id] :['discounts.store']
    ]) }}

    <div class="form-group">
        {{ Form::label('title') }} <span class="required">*</span>
        {{ Form::text('title', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('service') }} <span class="required">*</span>
        {{ Form::text('service', null, ['class' => 'form-control', 'placeholder' => 'Universal, Seminar, Individual Coaching, Application Layout, Application Package']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('amount') }} <span class="required">*</span>
            {{ Form::number('amount', null, ['class' => 'form-control', 'step' => '0.01', 'min' => 0]) }}
        </div>
        <div class="col-md-2">
            {{ Form::label('percentage') }}
            <br>
            {{ Form::checkbox('percentage', null) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('validity') }} <span class="required">*</span>
            {{ Form::number('validity', null, ['class' => 'form-control', 'min' => 0]) }}
        </div>
        <div class="col-md-1">
            {{ Form::label('permanent') }} <span class="required">*</span>
            {{ Form::checkbox('permanent', null) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('start_date') }} <span class="required">*</span>
        {{ Form::text('startdate', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('code') }} <span class="required">*</span>
        </div>
        <div class="col-md-12">
            <div class="input-group">
                {{ Form::text('code', null, ['class' => 'form-control']) }}
                <span class="input-group-btn">{{ Form::button('Random Code', ['class' => 'btn btn-default', 'onclick' => 'getCode()', 'style' => 'height: 34px']) }}</span>
            </div>
        </div>
    </div>

    {{ Form::submit($discount->exists ? 'Save Discount' : 'Create New Discount', ['class' => 'btn btn-success']) }}
    <a href="{{ route('discounts.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        $('#percentage').on('change', function () {
            if ($(this).is(':checked')) {
                document.getElementById('amount').max = 100;
                if(document.getElementById('amount').value > 100){
                    document.getElementById('amount').value = 100;
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('permanent').checked) {
                document.getElementById('validity').disabled = true;
            }
        }, false);

        $('input[name=startdate]').datetimepicker({
            allowInputToggle: true,
            format: 'YYYY-MM-DD',
            showClear: true,
            defaultDate: '{{ old('startdate', $discount->startdate) }}'
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