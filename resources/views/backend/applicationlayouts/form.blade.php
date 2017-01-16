@extends('layouts.backend')

@section('title', $layout->exists ? 'Editing '.$layout->title : 'Create New Application Layout')

@section('content')
    {{ Form::model($layout, [
    'method' => $layout->exists ? 'put' : 'post',
    'route' => $layout->exists ? ['applicationlayouts.update', $layout->id] :['applicationlayouts.store'],
    'enctype' => 'multipart/form-data'
    ]) }}

    <div class="form-group">
        {{ Form::label('title') }}
        {{ Form::text('title', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('price') }}
        {{ Form::number('price', null, ['class' => 'form-control', 'step' => '0.01', 'min' => 0]) }}
    </div>

    <div class="form-group">
        {{ Form::label('description') }}
        {{ Form::textarea('description', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('preview_file_(PNG)') }}
            <br>
            @if($layout->preview)
                <div class="col-md-2">
                    {{ $layout->getPreviewFilename() }}
                </div>
                <div class="col-md-1">
                    <a href="/backend/applicationlayouts/files/<?php echo $layout->id ?>/deletepreview"><span
                                class="glyphicon glyphicon-remove"></span></a></div>
                <br>
            @endif
        </div>
        <div class="col-md-5">
            <br>
            {{ Form::file('preview') }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('layout_file_(DOCX)') }}
            <br>
            @if($layout->layout)
                <div class="col-md-2">
                    {{ $layout->getLayoutFilename() }}
                </div>
                <div class="col-md-1">
                    <a href="/backend/applicationlayouts/files/<?php echo $layout->id ?>/deletelayout"><span
                                class="glyphicon glyphicon-remove"></span></a></div>
                <br>
            @endif
        </div>
        <div class="col-md-5">
            <br>
            {{ Form::file('layout') }}
        </div>
    </div>

    {{ Form::submit($layout->exists ? 'Save Layout' : 'Create New Layout', ['class' => 'btn btn-success']) }}
    <a href="{{ route('applicationlayouts.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        new SimpleMDE().render();
    </script>
@endsection