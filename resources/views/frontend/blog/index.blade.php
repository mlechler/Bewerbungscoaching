@extends('layouts.frontend')

@section('title', 'Blog Posts')

@section('content')
    <table class="table">
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td class="vertical-center blogPostPreviewHeading"
                    style="background-image: url({{ $post->getPreview() }})">
                    @if($post->getPreview() == null)
                        Currently no Preview available.
                    @endif
                </td>
                <td>
                    <a href="{{ route('frontend.blog.detail', $post->slug) }}"><h3>{{ $post->title }}</h3></a>
                    <h6>Published at {{ $post->publishedDate() }} by {{ $post->getName() }}</h6>
                </td>
            </tr>
            <tr>
                <td>

                </td>
                <td>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $posts->links() }}
@endsection