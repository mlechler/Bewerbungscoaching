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
                {{ Form::number('maxMembers', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('duration') }}
                {{ Form::number('duration', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('price') }}
                {{ Form::number('price', null, ['class' => 'form-control', 'step' => '0.01']) }}
            </div>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('description') }}
        {{ Form::textarea('description', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('files') }}
            <br>
            @if($files != null)
                @foreach($files as $file)
                    {{ $file }}
                    <br>
                @endforeach
            @endif
        </div>
        <div class="col-md-5">
            <br>
            {{ Form::file('file', null, ['class' => 'form-control']) }}
        </div>
    </div>

    {{ Form::submit($seminar->exists ? 'Save Seminar' : 'Create New Seminar', ['class' => 'btn btn-success']) }}
    <a href="{{ route('seminars.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        new SimpleMDE().render();
    </script>
@endsection