@extends('layouts.backend')

@section('title', $seminar->exists ? 'Editing '.$seminar->title : 'Create New Seminar')

@section('content')
    {{ Form::model($seminar, [
    'method' => $seminar->exists ? 'put' : 'post',
    'route' => $seminar->exists ? ['seminars.update', $seminar->id] :['seminars.store'],
    'enctype' => 'multipart/form-data'
    ]) }}

    <div class="form-group">
        {{ Form::label('title') }}
        {{ Form::text('title', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('services') }}
        {{ Form::text('services', null, ['class' => 'form-control']) }}
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('maximum_participants') }}
                {{ Form::number('maxMembers', null, ['class' => 'form-control', 'min' => 0]) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('duration') }}
                {{ Form::number('duration', null, ['class' => 'form-control', 'min' => 0]) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('price') }}
                {{ Form::number('price', null, ['class' => 'form-control', 'step' => '0.01', 'min' => 0]) }}
            </div>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('description') }}
        {{ Form::textarea('description', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('files_(PNG,_PDF_or_DOCX)') }}
            <br>
            @if(!$seminar->seminarFiles->isEmpty())
                @foreach($seminar->seminarFiles as $file)
                    <div class="col-md-2">
                        {{ $file->name }}
                    </div>
                    <div class="col-md-1">
                        <a href="/backend/seminars/files/<?php echo $file->id ?>/delete"><span
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

    {{ Form::submit($seminar->exists ? 'Save Seminar' : 'Create New Seminar', ['class' => 'btn btn-success']) }}
    <a href="{{ route('seminars.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        new SimpleMDE().render();
    </script>
@endsection