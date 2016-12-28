@extends('layouts.backend')

@section('title', 'Deleting '.$member->lastname.' '.$member->firstname)

@section('heading', 'Deleting '.$member->lastname.' '.$member->firstname)

@section('content')
    {{ Form::open([
    'method' => 'delete',
    'route' => ['members.destroy', $member->id]
    ]) }}

    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete a member. This action cannot be undone. Are you sure you
        want to continue?
    </div>

    {{ Form::submit('Yes, delete this member!', ['class' => 'btn btn-danger']) }}
    <a href="/admin/members" class="btn btn-success">
        <strong>No, get me out of here!</strong>
    </a>

    {{ Form::close() }}
@endsection