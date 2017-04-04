@extends('layouts.frontend')

@section('title', 'Upload Files For Checking')

@section('content')
    {{ Form::open([
    'method' => 'post',
  'route' => 'frontend.myinformation.files',
  'enctype' => 'multipart/form-data'
  ]) }}

    <div class="form-group row">
        <div class="col-md-10">
            {{ Form::label('files_(PNG,_PDF_or_DOCX)') }}
            <br>
            @if(!$loggedInUser->memberFiles->isEmpty())
                @foreach($loggedInUser->memberFiles as $file)
                    <div class="col-md-5">
                        <a href="{{ $file->download }}" target="_blank">{{ $file->name }}</a>
                    </div>
                    <div class="col-md-1">
                        <a href="{{ route('frontend.myinformation.deleteFile', $file->id) }}"><span
                                    class="glyphicon glyphicon-remove"></span></a></div>
                    <br>
                @endforeach
            @endif
        </div>
        <div class="col-md-2">
            <a href="{{ route('frontend.myinformation.deleteAllFiles') }}" class="btn btn-danger">Delete All Files</a>
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

    {{ Form::submit('Save Files', ['class' => 'btn btn-success']) }}
    <a href="{{ route('frontend.myinformation.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        $('input[id=files]').change(function () {
            var names = [];
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
                names.push(', ');
            }
            names.splice(-1, 1);
            $('#filenames').html(names);
        });
    </script>
@endsection