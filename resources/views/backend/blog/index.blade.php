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
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
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
                    <a href="/admin/blog/<?php echo $post->id ?>/edit"><span
                                class="glyphicon glyphicon-edit"></span></a>
                </td>
                <td>
                    <a href="/admin/blog/<?php echo $post->id ?>/confirm"><span
                                class="glyphicon glyphicon-remove"></span></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $posts->links() }}
@endsection