@extends('layouts.frontend')

@section('title', 'Welcome')

@section('content')
    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading blogPostPreviewHeading"
                         style="background-image: url({{ $post->getPreview() }})">
                        @if($post->getPreview() == null)
                            <div class="vertical-center blogPostPreviewHeading" align="center">
                                Currently no Preview available.
                            </div>
                        @endif
                    </div>
                    <div class="panel-body blogPostPreviewBody">
                        <h3>{{ $post->title }}</h3><br>
                        @if($post->excerpt)
                            {!! $post->shortExcerptHtml() !!}
                            <br><br>
                            <div style="position: absolute; bottom:25px">
                                <a href="{{ route('frontend.blog.detail', $post->slug) }}" target="_blank">Read more</a>
                            </div>
                        @else
                            {!! $post->shortBodyHtml() !!}
                            <br><br>
                            <div style="position: absolute; bottom:25px">
                                <a href="{{ route('frontend.blog.detail', $post->slug) }}" target="_blank">Read more</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection