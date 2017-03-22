@extends('layouts.frontend')

@section('title', 'Welcome')

@section('content')
    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-4">
                <h4>{{ $post->title }}</h4><br>
                {!! $post->excerptHtml() !!}
            </div>
        @endforeach
    </div>
@endsection