@extends('layouts.frontend')

@section('title', 'Welcome')

@section('content')
    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-4">
                <div class="panel panel-default" style="min-height:300px">
                    <div class="panel-heading">
                        {!! $post->getPreview() !!}
                    </div>
                    <div class="panel-body">
                        <h4>{{ $post->title }}</h4><br>
                        @if($post->excerpt)
                            {!! $post->shortExcerptHtml() !!}
                            <a href="{{ route('frontend.blog.detail', $post->id) }}" target="_blank">Read more</a>
                        @else
                            {!! $post->shortBodyHtml !!}
                            <a href="{{ route('frontend.blog.detail', $post->id) }}" target="_blank">Read more</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection