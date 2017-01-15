@extends('layouts.backend')

@section('title', $invoice->exists ? 'Editing Invoice No.'.$invoice->id : 'Create New Invoice')

@section('content')
    {{ Form::model($invoice, [
    'method' => $invoice->exists ? 'put' : 'post',
    'route' => $invoice->exists ? ['invoices.update', $invoice->id] : ['invoices.store']
    ]) }}

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('member') }}
            {{ Form::select('member_id', $members, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('individual_coaching') }}
            {{ Form::select('individualcoaching_id', $coachings, null, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-6">
            {{ Form::label('booking') }}
            {{ Form::select('booking_id', $bookings, null, ['class' => 'form-control']) }}
        </div>
    </div>

    {{ Form::submit($invoice->exists ? 'Save Invoice' : 'Create New Invoice', ['class' => 'btn btn-success']) }}
    <a href="{{ route('invoices.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}
@endsection