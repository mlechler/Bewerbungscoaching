@extends('layouts.backend')

@section('title', 'Deleting Invoice No.'.$invoice->id)

@section('content')
    {{ Form::open([
    'method' => 'delete',
    'route' => ['invoices.destroy', $invoice->id]
    ]) }}

    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete an Invoice. All Files and Informations belonging to this Invoice will be deleted. This action cannot be undone.
        <br>
        Are you sure you want to continue?
    </div>

    {{ Form::submit('Yes, delete this Invoice!', ['class' => 'btn btn-danger']) }}
    <a href="{{ route('invoices.index') }}" class="btn btn-success">
        <strong>No, get me out of here!</strong>
    </a>

    {{ Form::close() }}
@endsection