@extends('layouts.backend')

@section('title', $package->exists ? 'Editing '.$package->title : 'Create New Application Package')

@section('content')
    {{ Form::model($package, [
    'method' => $package->exists ? 'put' : 'post',
    'route' => $package->exists ? ['applicationpackages.update', $package->id] :['applicationpackages.store'],
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

    {{ Form::submit($package->exists ? 'Save Application Package' : 'Create New Application Package', ['class' => 'btn btn-success']) }}
    <a href="{{ route('applicationpackages.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        new SimpleMDE().render();
    </script>
@endsection