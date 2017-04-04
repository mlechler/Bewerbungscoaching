@extends('layouts.backend')

@section('title', $packagepurchase->exists ? 'Editing VALUE' : 'Create New Package Purchase')

@section('content')
    {{ Form::model($packagepurchase, [
    'method' => $packagepurchase->exists ? 'put' : 'post',
    'route' => $packagepurchase->exists ? ['packagepurchases.update', $packagepurchase->id] :['packagepurchases.store'],
    'enctype' => 'multipart/form-data'
    ]) }}

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('member') }} <span class="required">*</span>
            {{ Form::select('member_id', $members, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('application_package') }} <span class="required">*</span>
            {{ Form::select('applicationpackage_id', $applicationpackages, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('price_inclusive_discount') }} <span class="required">*</span>
            {{ Form::number('price_incl_discount', null, ['class' => 'form-control', 'step' => '0.01', 'min' => 0]) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('package_file_(ZIP_or_RAR)') }}
            <br>
            @if($packagepurchase->path)
                <div class="col-md-2">
                    {{ $packagepurchase->getFilename() }}
                </div>
                <div class="col-md-1">
                    <a href="{{ route('packagepurchases.deleteFile', $packagepurchase->id) }}"><span
                                class="glyphicon glyphicon-remove"></span></a></div>
                <br>
            @endif
        </div>
        <div class="col-md-5">
            <br>
            <label class="btn btn-default btn-file">
                Browse File
                {{ Form::file('package', ['class' => 'form-control', 'id' => 'package']) }}
            </label>
            <span id="packageFilename"></span>
        </div>
    </div>

    {{ Form::submit($packagepurchase->exists ? 'Save Package Purchase' : 'Create New Package Purchase', ['class' => 'btn btn-success']) }}
    <a href="{{ route('packagepurchases.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        $('#package').on('change', function () {
            var pathParts = $(this).val().split('\\');
            var fileName = pathParts[pathParts.length-1];
            $('#packageFilename').html(fileName);
        });
    </script>
@endsection