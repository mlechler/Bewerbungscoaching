@extends('layouts.frontend')

@section('title', 'Blog Posts')

@section('content')
    <table class="table table-hover">
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td class="vertical-center" align="center">
                    {!! $post->getPreview() !!}
                </td>
                <td>
                    <a href="{{ route('frontend.blog.detail', $post->id) }}"><h3>{{ $post->title }}</h3></a>
                    <h6>Published at {{ $post->publishedDate() }} by {{ $post->getName() }}</h6>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $posts->links() }}
@endsection