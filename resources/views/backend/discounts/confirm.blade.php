@extends('layouts.backend')

@section('title', 'Deleting '.$discount->title)

@section('content')
    {{ Form::open([
    'method' => 'delete',
    'route' => ['discounts.destroy', $discount->id]
    ]) }}

    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete a discount. This action cannot be undone. Are you sure you
        want to continue?
    </div>

    {{ Form::submit('Yes, delete this discount!', ['class' => 'btn btn-danger']) }}
    <a href="{{ route('discounts.index') }}" class="btn btn-success">
        <strong>No, get me out of here!</strong>
    </a>

    {{ Form::close() }}
@endsection