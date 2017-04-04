@extends('layouts.backend')

@section('title', $seminar->exists ? 'Editing '.$seminar->title : 'Create New Seminar')

@section('content')
    {{ Form::model($seminar, [
    'method' => $seminar->exists ? 'put' : 'post',
    'route' => $seminar->exists ? ['seminars.update', $seminar->id] :['seminars.store'],
    'enctype' => 'multipart/form-data'
    ]) }}

    <div class="form-group">
        {{ Form::label('title') }} <span class="required">*</span>
        {{ Form::text('title', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('services') }} <span class="required">*</span>
        {{ Form::text('services', null, ['class' => 'form-control']) }}
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('maximum_participants') }} <span class="required">*</span>
                {{ Form::number('maxMembers', null, ['class' => 'form-control', 'min' => 0]) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('duration') }} <span class="required">*</span>
                {{ Form::number('duration', null, ['class' => 'form-control', 'min' => 0]) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('price') }} <span class="required">*</span>
                {{ Form::number('price', null, ['class' => 'form-control', 'step' => '0.01', 'min' => 0]) }}
            </div>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('description') }} <span class="required">*</span>
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
                        <a href="{{ route('seminars.deleteFile', $file->id) }}"><span
                                    class="glyphicon glyphicon-remove"></span></a></div>
                    <br>
                @endforeach
            @endif
        </div>
        <div class="col-md-12">
            <br>
            <label class="btn btn-default btn-file">
                Browse Files
                {{ Form::file('files[]', ['multiple' => 'multiple', 'class' => 'form-control', 'id' => 'files']) }}
            </label>
            <span id="filenames"></span>
        </div>
    </div>

    {{ Form::submit($seminar->exists ? 'Save Seminar' : 'Create New Seminar', ['class' => 'btn btn-success']) }}
    <a href="{{ route('seminars.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        new SimpleMDE({
            toolbar: ["bold", "italic", "strikethrough", "heading", "|", "code", "quote", "unordered-list", "ordered-list",
                "clean-block", "|", "link", "image", "table", "horizontal-rule", "|", "preview", "side-by-side", "fullscreen", "|", "guide"]
        }).render();

        $('input[id=files]').change(function() {
            var names = [];
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
                names.push(', ');
            }
            names.splice(-1,1);
            $('#filenames').html(names);
        });
    </script>
@endsection