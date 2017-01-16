@extends('layouts.backend')

@section('title', 'Deleting VALUE')

@section('content')
    {{ Form::open([
    'method' => 'delete',
    'route' => ['memberdiscounts.destroy', $memberdiscount->id]
    ]) }}

    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete a memberdiscount. This action cannot be undone. Are you sure you
        want to continue?
    </div>

    {{ Form::submit('Yes, delete this memberdiscount!', ['class' => 'btn btn-danger']) }}
    <a href="{{ route('memberdiscounts.index') }}" class="btn btn-success">
        <strong>No, get me out of here!</strong>
    </a>

    {{ Form::close() }}
@endsection