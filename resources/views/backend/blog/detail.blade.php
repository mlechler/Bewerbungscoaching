@extends('layouts.backend')

@section('title', 'Details of '.$post->title)

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Title</h4>
            </td>
            <td>
                <h4>{{ $post->title }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Author</h4>
            </td>
            <td>
                <h4>{{ $post->getName() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Slug</h4>
            </td>
            <td>
                <h4>{{ $post->slug}}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Published At</h4>
            </td>
            <td>
                <h4>{{ $post->publishedDate() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Excerpt</h4>
            </td>
            <td>
                <h4>{!! $post->excerptHtml() !!}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Body</h4>
            </td>
            <td>
                <h4>{!! $post->bodyHtml() !!}</h4>
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('blog.index') }}" class="btn btn-danger">Back</a>
@endsection