@extends('layouts.backend')

@section('title', $page->exists ? 'Editing '.$page->title : 'Create New Page')

@section('content')
    {{ Form::model($page, [
    'method' => $page->exists ? 'put' : 'post',
    'route' => $page->exists ? ['pages.update', $page->id] :['pages.store']
    ]) }}

    <div class="form-group">
        {{ Form::label('title') }}
        {{ Form::text('title', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('uri', 'URI') }}
            {{ Form::text('uri', null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-6">
            {{ Form::label('name') }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'This name is used to generate links to the page.']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('template') }}
        </div>
        <div class="col-md-4">
            {{ Form::select('template', $templates, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('order') }}
        </div>
        <div class="col-md-2">
            {{ Form::select('order', [
                '' => '',
                'before' => 'Before',
                'after' => 'After',
                'childOf' => 'Child Of'
            ], null, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-5">
            {{ Form::select('orderPage', ['' => ''] + $orderPages->pluck('paddedTitle', 'id')->toArray(), null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('pagecontent') }}
        {{ Form::textarea('pagecontent', null, ['class' => 'form-control']) }}
    </div>

    {{ Form::submit($page->exists ? 'Save Page' : 'Create New Page', ['class' => 'btn btn-success']) }}
    <a href="{{ route('pages.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        new SimpleMDE().render();
    </script>
@endsection