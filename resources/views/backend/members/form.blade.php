@extends('layouts.backend')

@section('title', $member->exists ? 'Editing '.$member->getName() : 'Create new Member')

@section('content')
    {{ Form::model($member, [
    'method' => $member->exists ? 'put' : 'post',
    'route' => $member->exists ? ['members.update', $member->id] :['members.store'],
    'enctype' => 'multipart/form-data'
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

    <div class="form-group row">
        <div class="col-md-2">
            {{ Form::label('zip_code') }}
            {{ Form::text('zip', $member->adress ? $member->adress->zip : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('city') }}
            {{ Form::text('city', $member->adress ? $member->adress->city : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('street') }}
            {{ Form::text('street', $member->adress ? $member->adress->street : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-2">
            {{ Form::label('housenumber') }}
            {{ Form::text('housenumber', $member->adress ? $member->adress->housenumber : null, ['class' => 'form-control']) }}
        </div>
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

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('role') }}
        </div>
        <div class="col-md-4">
            {{ Form::select('role_id', $roles, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('password') }}
        {{ Form::password('password', ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('password_confirmation') }}
        {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('files_(PNG,_PDF_or_DOCX)') }}
            <br>
            @if(!$member->memberFiles->isEmpty())
                @foreach($member->memberFiles as $file)
                    <div class="col-md-2">
                        {{ $file->name }}
                    </div>
                    <div class="col-md-1">
                        <a href="{{ route('members.deleteFile', $file->id) }}"><span
                                    class="glyphicon glyphicon-remove"></span></a></div>
                    <br>
                @endforeach
            @endif
        </div>
        <div class="col-md-5">
            <br>
            {{ Form::file('files[]', ['multiple' => 'multiple'], ['class' => 'form-control']) }}
        </div>
    </div>

    {{ Form::submit($member->exists ? 'Save Member' : 'Create new Member', ['class' => 'btn btn-success']) }}
    <a href="{{ route('members.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        $('input[name=birthday]').datetimepicker({
            allowInputToggle: true,
            format: 'YYYY-MM-DD',
            showClear: true,
            defaultDate: '{{ old('birthday', $member->birthday) }}'
        });
    </script>
@endsection