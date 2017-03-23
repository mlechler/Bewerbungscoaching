@extends('layouts.frontend')

@section('title', 'Individual Coaching Contact')

@section('content')
    {{ Form::open(['method' => 'post',
    'route' => 'frontend.individualcoachings.contact']) }}

    <div class="form-group">
        {{ Form::label('name') }} <span class="required">*</span>
        {{ Form::text('name', $loggedInUser ? $loggedInUser->firstname . ' ' . $loggedInUser->lastname : null, ['class' => 'form-control', $loggedInUser ? 'disabled' : null]) }}
    </div>

    <div class="form-group">
        {{ Form::label('email') }} <span class="required">*</span>
        {{ Form::text('email', $loggedInUser ? $loggedInUser->email : null, ['class' => 'form-control', $loggedInUser ? 'disabled' : null]) }}
    </div>

    <div class="form-group">
        {{ Form::label('category') }} <span class="required">*</span>
        {{ Form::select('category', [
            '' => 'Select a category',
            'trial' => 'Trial',
            'appointment' => 'New Appointment',
        ], '', ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('message') }} <span class="required">*</span>
        {{ Form::textarea('message', null, ['class' => 'form-control']) }}
    </div>

    {{ Form::submit('Contact Us', ['class' => 'btn btn-success']) }}
    <a href="{{ route('frontend.individualcoachings.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        new SimpleMDE({
            toolbar: ["bold", "italic", "strikethrough", "heading", "|", "code", "quote", "unordered-list", "ordered-list",
                "clean-block", "|", "link", "image", "table", "horizontal-rule", "|", "preview", "side-by-side", "fullscreen", "|", "guide"]
        }).render();
    </script>
@endsection
