@extends('layouts.backend')

@section('title', 'Deleting '.$package->title)

@section('content')
    {{ Form::open([
    'method' => 'delete',
    'route' => ['applicationpackages.destroy', $package->id]
    ]) }}

    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete an Application Package. All Files and Informations belonging to this Application Package will be deleted. This action cannot be undone.
        <br>
        Are you sure you want to continue?
    </div>

    {{ Form::submit('Yes, delete this application package!', ['class' => 'btn btn-danger']) }}
    <a href="{{ route('applicationpackages.index') }}" class="btn btn-success">
        <strong>No, get me out of here!</strong>
    </a>

    {{ Form::close() }}
@endsection