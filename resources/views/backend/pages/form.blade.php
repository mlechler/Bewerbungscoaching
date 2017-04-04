@extends('layouts.backend')

@section('title', $page->exists ? 'Editing '.$page->title : 'Create New Page')

@section('content')
    {{ Form::model($page, [
    'method' => $page->exists ? 'put' : 'post',
    'route' => $page->exists ? ['pages.update', $page->id] :['pages.store']
    ]) }}

    <div class="form-group">
        {{ Form::label('title') }} <span class="required">*</span>
        {{ Form::text('title', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('uri', 'URI') }} <span class="required">*</span>
            {{ Form::text('uri', null, ['class' => 'form-control']) }}
        </div>

        <div class="col-md-6">
            {{ Form::label('name') }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'This name is used to generate links to the page.']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            {{ Form::label('order') }} <span class="required">*</span>
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
        {{ Form::label('pagecontent') }} <span class="required">*</span>
        {{ Form::textarea('pagecontent', null, ['class' => 'form-control']) }}
    </div>

    {{ Form::submit($page->exists ? 'Save Page' : 'Create New Page', ['class' => 'btn btn-success']) }}
    <a href="{{ route('pages.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        new SimpleMDE({
            toolbar: ["bold", "italic", "strikethrough", "heading", "|", "code", "quote", "unordered-list", "ordered-list",
                "clean-block", "|", "link", "image", "table", "horizontal-rule", "|", "preview", "side-by-side", "fullscreen", "|", "guide"]
        }).render();
    </script>
@endsection