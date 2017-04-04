@extends('layouts.backend')

@section('title', $layoutpurchase->exists ? 'Editing VALUE' : 'Create New Layout Purchase')

@section('content')
    {{ Form::model($layoutpurchase, [
    'method' => $layoutpurchase->exists ? 'put' : 'post',
    'route' => $layoutpurchase->exists ? ['layoutpurchases.update', $layoutpurchase->id] :['layoutpurchases.store']
    ]) }}

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('member') }} <span class="required">*</span>
            {{ Form::select('member_id', $members, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('application_layout') }} <span class="required">*</span>
            {{ Form::select('applicationlayout_id', $applicationlayouts, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('price_inclusive_discount') }} <span class="required">*</span>
            {{ Form::number('price_incl_discount', null, ['class' => 'form-control', 'step' => '0.01', 'min' => 0]) }}
        </div>
    </div>

    {{ Form::submit($layoutpurchase->exists ? 'Save Layout Purchase' : 'Create New Layout Purchase', ['class' => 'btn btn-success']) }}
    <a href="{{ route('layoutpurchases.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}
@endsection