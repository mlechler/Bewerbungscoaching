@extends('layouts.backend')

@section('title', $discount->exists ? 'Editing '.$discount->title : 'Create New Discount')

@section('content')
    {{ Form::model($discount, [
    'method' => $discount->exists ? 'put' : 'post',
    'route' => $discount->exists ? ['discounts.update', $discount->id] :['discounts.store']
    ]) }}

    <div class="form-group">
        {{ Form::label('title') }}
        {{ Form::text('title', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('service') }}
        {{ Form::text('service', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('amount') }}
            {{ Form::number('amount', null, ['class' => 'form-control', 'step' => '0.01', 'min' => 0]) }}
        </div>
        <div class="col-md-2">
            {{ Form::label('percentage') }}
            <br>
            {{ Form::checkbox('percentage', null) }}
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
    </script>
@endsection