@extends('layouts.backend')

@section('title', 'Blog Posts')

@section('content')
    <a href="{{ route('blog.create') }}" class="btn btn-primary">Create New Post</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>Slug</th>
            <th>Author</th>
            <th>Published</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($posts->isEmpty())
            <tr>
                <td colspan="7" align="center">There are no blog posts.</td>
            </tr>
        @else
            @foreach($posts as $post)
                <tr class="{{ $post->publishedHighlight() }}">
                    <td>
                        {{ $post->title }}
                    </td>
                    <td>
                        {{ $post->slug }}
                    </td>
                    <td>
                        {{ $post->getName() }}
                    </td>
                    <td>
                        {{ $post->publishedDate() }}
                    </td>
                    <td>
                        <a href="/backend/blog/<?php echo $post->id ?>/detail"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
                    </td>
                    <td>
                        <a href="/backend/blog/<?php echo $post->id ?>/edit"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/backend/blog/<?php echo $post->id ?>/confirm"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $posts->links() }}
@endsection