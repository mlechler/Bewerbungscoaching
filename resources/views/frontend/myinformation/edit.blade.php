@extends('layouts.frontend')

@section('title', 'Edit Personal Information')

@section('content')
    {{ Form::open([
    'method' => 'post',
    'route' => ['frontend.myinformation.update',$loggedInUser->id]
    ]) }}

    <div class="form-group">
        {{ Form::label('lastname') }}
        {{ Form::text('lastname', $loggedInUser->lastname, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('firstname') }}
        {{ Form::text('firstname', $loggedInUser->firstname, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('birthday') }}
        {{ Form::text('birthday', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('phone') }}
        {{ Form::text('phone', $loggedInUser->phone, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('mobile') }}
        {{ Form::text('mobile', $loggedInUser->mobile, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('email') }}
        {{ Form::text('email', $loggedInUser->email, ['class' => 'form-control']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            {{ Form::label('zip_code') }}
            {{ Form::text('zip', $loggedInUser->address ? $loggedInUser->address->zip : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('city') }}
            {{ Form::text('city', $loggedInUser->address ? $loggedInUser->address->city : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('street') }}
            {{ Form::text('street', $loggedInUser->address ? $loggedInUser->address->street : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-2">
            {{ Form::label('housenumber') }}
            {{ Form::text('housenumber', $loggedInUser->address ? $loggedInUser->address->housenumber : null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('job') }}
        {{ Form::text('job', $loggedInUser->job, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('employer') }}
        {{ Form::text('employer', $loggedInUser->employer, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('university') }}
        {{ Form::text('university', $loggedInUser->university, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('course_of_studies') }}
        {{ Form::text('courseofstudies', $loggedInUser->courseofstudies, ['class' => 'form-control']) }}
    </div>

    {{ Form::submit('Save Personal Information', ['class' => 'btn btn-success']) }}
    <a href="{{ route('frontend.myinformation.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        $('input[name=birthday]').datetimepicker({
            allowInputToggle: true,
            format: 'YYYY-MM-DD',
            showClear: true,
            defaultDate: '{{ old('birthday', $loggedInUser->birthday) }}'
        });
    </script>
@endsection