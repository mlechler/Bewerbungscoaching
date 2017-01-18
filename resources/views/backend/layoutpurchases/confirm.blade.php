@extends('layouts.backend')

@section('title', 'Deleting VALUE')

@section('content')
    {{ Form::open([
    'method' => 'delete',
    'route' => ['layoutpurchases.destroy', $layoutpurchase->id]
    ]) }}

    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete a Layout Purchase. All Files and Informations belonging to this Layout Purchase will be deleted. This action cannot be undone.
        <br>
        Are you sure you want to continue?
    </div>

    {{ Form::submit('Yes, delete this Layout Purchase!', ['class' => 'btn btn-danger']) }}
    <a href="{{ route('layoutpurchases.index') }}" class="btn btn-success">
        <strong>No, get me out of here!</strong>
    </a>

    {{ Form::close() }}
@endsection