@extends('layouts.backend')

@section('title', $invoice->exists ? 'Editing Invoice No.'.$invoice->id : 'Create New Invoice')

@section('content')
    {{ Form::model($invoice, [
    'method' => $invoice->exists ? 'put' : 'post',
    'route' => $invoice->exists ? ['invoices.update', $invoice->id] : ['invoices.store'],
    'name' => 'invoiceForm'
    ]) }}

    {{ Form::hidden('selectBoxType', null, ['class' => 'form-control', 'id' => 'selectBoxType']) }}

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('member') }}
            {{ Form::select('member_id', $members, null, ['class' => 'form-control']) }}
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-md-2">
            {{ Form::label('individual coaching') }}
        </div>
        <div class="col-md-1">
            {{ Form::radio('type','individualcoaching') }}
        </div>
        <div class="col-md-9">
            {{ Form::text('selectBox', null, ['class' => 'form-control', 'id' => 'individualcoaching', 'style' => 'visibility: hidden']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            {{ Form::label('seminar') }}
        </div>
        <div class="col-md-1">
            {{ Form::radio('type','seminar') }}
        </div>
        <div class="col-md-9">
            {{ Form::text('selectBox', null, ['class' => 'form-control', 'id' => 'seminar', 'style' => 'visibility: hidden']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            {{ Form::label('application_package') }}
        </div>
        <div class="col-md-1">
            {{ Form::radio('type','application_package') }}
        </div>
        <div class="col-md-9">
            {{ Form::text('selectBox', null, ['class' => 'form-control', 'id' => 'application_package', 'style' => 'visibility: hidden']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            {{ Form::label('layout') }}
        </div>
        <div class="col-md-1">
            {{ Form::radio('type','layout') }}
        </div>
        <div class="col-md-9">
            {{ Form::text('selectBox', null, ['class' => 'form-control', 'id' => 'layout', 'style' => 'visibility: hidden']) }}
        </div>
    </div>

    {{ Form::submit($invoice->exists ? 'Save Invoice' : 'Create New Invoice', ['class' => 'btn btn-success']) }}
    <a href="{{ route('invoices.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        var radio = document.invoiceForm.type;
        for (var i = 0; i < radio.length; i++) {
            radio[i].onclick = function () {
                var inputs = document.getElementsByName('selectBox');
                for(var i = 0; i<inputs.length; i++){
                    inputs[i].style.visibility = 'hidden'}
                document.getElementById(this.value).style.visibility = 'visible';
                document.getElementById('selectBoxType').value = this.value;
            };
        }
    </script>
@endsection