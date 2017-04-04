@extends('layouts.backend')

@section('title', $employee->exists ? 'Editing '.$employee->getName() : 'Create New Employee')

@section('content')
    {{ Form::model($employee, [
    'method' => $employee->exists ? 'put' : 'post',
    'route' => $employee->exists ? ['employees.update', $employee->id] :['employees.store'],
    'enctype' => 'multipart/form-data'
    ]) }}

    <div class="form-group">
        {{ Form::label('lastname') }} <span class="required">*</span>
        {{ Form::text('lastname', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('firstname') }} <span class="required">*</span>
        {{ Form::text('firstname', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('birthday') }} <span class="required">*</span>
        {{ Form::text('birthday', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('phone') }} <span class="required">*</span>
        {{ Form::text('phone', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('mobile') }} <span class="required">*</span>
        {{ Form::text('mobile', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('email') }} <span class="required">*</span>
        {{ Form::text('email', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            {{ Form::label('zip_code') }} <span class="required">*</span>
            {{ Form::text('zip', $employee->address ? $employee->address->zip : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('city') }} <span class="required">*</span>
            {{ Form::text('city', $employee->address ? $employee->address->city : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-4">
            {{ Form::label('street') }} <span class="required">*</span>
            {{ Form::text('street', $employee->address ? $employee->address->street : null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-2">
            {{ Form::label('housenumber') }} <span class="required">*</span>
            {{ Form::text('housenumber', $employee->address ? $employee->address->housenumber : null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('role') }} <span class="required">*</span>
            {{ Form::select('role_id', $roles, null, ['class' => 'form-control', $employee->exists ? $backendUser->isAdmin() ? null : 'disabled' : null]) }}
        </div>
        <div id="colorpicker" class="col-md-6 ">
            {{ Form::label('color') }} <span class="required">*</span>
            <div class="input-group colorpicker-component">
                {{ Form::text('color', $employee->color ? $employee->color : '#000000', ['class' => 'form-control']) }}
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('password') }} <span class="required">*</span>
        {{ Form::password('password', ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('password_confirmation') }} <span class="required">*</span>
        {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('files_(PNG,_PDF_or_DOCX)') }}
            <br>
            @if(!$employee->employeeFiles->isEmpty())
                @foreach($employee->employeeFiles as $file)
                    <div class="col-md-2">
                        <a href="{{ $file->download }}" target="_blank">{{ $file->name }}</a>
                    </div>
                    <div class="col-md-1">
                        <a href="{{ route('employees.deleteFile', $file->id) }}"><span
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

    {{ Form::submit($employee->exists ? 'Save Employee' : 'Create New Employee', ['class' => 'btn btn-success']) }}
    @if($backendUser->isAdmin())
        <a href="{{ route('employees.index') }}" class="btn btn-danger">Cancel</a>
    @else
        <a href="{{ route('employees.detail', $backendUser->id) }}" class="btn btn-danger">Cancel</a>
    @endif
    {{ Form::close() }}

    <script>
        $('input[name=birthday]').datetimepicker({
            allowInputToggle: true,
            format: 'YYYY-MM-DD',
            showClear: true,
            defaultDate: '{{ old('birthday', $employee->birthday) }}'
        });

        $('input[id=files]').change(function () {
            var names = [];
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
                names.push(', ');
            }
            names.splice(-1, 1);
            $('#filenames').html(names);
        });

        $(function () {
            $('#colorpicker').colorpicker();
        });
    </script>
@endsection