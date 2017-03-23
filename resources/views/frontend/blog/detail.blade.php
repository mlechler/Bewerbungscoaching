@extends('layouts.frontend')

@section('title', 'Blog Post')

@section('content')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <h2>{{ $post->title }}</h2>
            Published at {{ $post->publishedDate() }} by {{ $post->getName() }}
            <br><br>
            {!! $post->bodyHtml() !!}
        </div>
        <div class="col-md-2"></div>
    </div>
@endsection