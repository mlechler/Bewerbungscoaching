@extends('layouts.backend')

@section('title', $member->exists ? 'Editing '.$member->getName() : 'Create new Member')

@section('content')
    {{ Form::model($member, [
    'method' => $member->exists ? 'put' : 'post',
    'route' => $member->exists ? ['members.update', $member->id] :['members.store']
    ]) }}

    <div class="form-group">
        {{ Form::label('lastname') }}
        {{ Form::text('lastname', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('firstname') }}
        {{ Form::text('firstname', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('birthday') }}
        {{ Form::text('birthday', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('phone') }}
        {{ Form::text('phone', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('mobile') }}
        {{ Form::text('mobile', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('email') }}
        {{ Form::text('email', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('job') }}
        {{ Form::text('job', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('employer') }}
        {{ Form::text('employer', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('university') }}
        {{ Form::text('university', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('course_of_studies') }}
        {{ Form::text('courseofstudies', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('password') }}
        {{ Form::password('password', ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('password_confirmation') }}
        {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
    </div>

    {{ Form::submit($member->exists ? 'Save Member' : 'Create new Member', ['class' => 'btn btn-success']) }}
    <a href="{{ route('members.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}
@endsection