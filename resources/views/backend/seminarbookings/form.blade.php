@extends('layouts.backend')

@section('title', $seminarbooking->exists ? 'Editing VALUE' : 'Create New Booking')

@section('content')
    {{ Form::model($seminarbooking, [
    'method' => $seminarbooking->exists ? 'put' : 'post',
    'route' => $seminarbooking->exists ? ['seminarbookings.update', $seminarbooking->id] :['seminarbookings.store']
    ]) }}

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('member') }} <span class="required">*</span>
            {{ Form::select('member_id', $members, null, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('appointment') }} <span class="required">*</span>
            {{ Form::select('appointment_id', $appointments, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('price_inclusive_discount') }} <span class="required">*</span>
            {{ Form::number('price_incl_discount', null, ['class' => 'form-control', 'step' => '0.01', 'min' => 0]) }}
        </div>
    </div>

    {{ Form::submit($seminarbooking->exists ? 'Save Booking' : 'Create New Booking', ['class' => 'btn btn-success']) }}
    <a href="{{ route('seminarbookings.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}
@endsection