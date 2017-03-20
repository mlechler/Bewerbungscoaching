@extends('layouts.backend')

@section('title', $layout->exists ? 'Editing '.$layout->title : 'Create New Application Layout')

@section('content')
    {{ Form::model($layout, [
    'method' => $layout->exists ? 'put' : 'post',
    'route' => $layout->exists ? ['applicationlayouts.update', $layout->id] :['applicationlayouts.store'],
    'enctype' => 'multipart/form-data'
    ]) }}

    <div class="form-group">
        {{ Form::label('title') }} <span class="required">*</span>
        {{ Form::text('title', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('price') }} <span class="required">*</span>
        {{ Form::number('price', null, ['class' => 'form-control', 'step' => '0.01', 'min' => 0]) }}
    </div>

    <div class="form-group">
        {{ Form::label('description') }} <span class="required">*</span>
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
                    <a href="{{ route('applicationlayouts.deletePreview', $layout->id) }}"><span
                                class="glyphicon glyphicon-remove"></span></a></div>
                <br>
            @endif
        </div>
        <div class="col-md-5">
            <br>
            <label class="btn btn-default btn-file">
                Browse File
                {{ Form::file('preview', ['class' => 'form-control', 'id' => 'preview' ]) }}
            </label>
            <span id="previewFilename"></span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('layout_file_(PDF_or_DOCX)') }}
            <br>
            @if($layout->layout)
                <div class="col-md-2">
                    {{ $layout->getLayoutFilename() }}
                </div>
                <div class="col-md-1">
                    <a href="{{ route('applicationlayouts.deleteLayout', $layout->id) }}"><span
                                class="glyphicon glyphicon-remove"></span></a></div>
                <br>
            @endif
        </div>
        <div class="col-md-5">
            <br>
            <label class="btn btn-default btn-file">
                Browse File
                {{ Form::file('layout', ['class' => 'form-control', 'id' => 'layout']) }}
            </label>
            <span id="layoutFilename"></span>
        </div>
    </div>

    {{ Form::submit($layout->exists ? 'Save Application Layout' : 'Create New Application Layout', ['class' => 'btn btn-success']) }}
    <a href="{{ route('applicationlayouts.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        new SimpleMDE().render();

        $('#preview').on('change', function () {
            var pathParts = $(this).val().split('\\');
            var fileName = pathParts[pathParts.length-1];
            $('#previewFilename').html(fileName);
        });

        $('#layout').on('change', function () {
            var pathParts = $(this).val().split('\\');
            var fileName = pathParts[pathParts.length-1];
            $('#layoutFilename').html(fileName);
        });
    </script>
@endsection