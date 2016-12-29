@extends('layouts.backend')

@section('title', 'Pages')

@section('heading', 'Pages')

@section('content')
    <a href="/admin/pages/create" class="btn btn-primary">Create new Page</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>URI</th>
            <th>Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($pages->isEmpty())
            <tr>
                <td colspan="5" align="center">There are no pages.</td>
            </tr>
        @else
            @foreach($pages as $page)
                <tr>
                    <td>
                        {{ $page->title }}
                    </td>
                    <td>
                        <a href="{{ url($page->uri) }}">{{ $page->prettyURI() }}</a>
                    </td>
                    <td>
                        {{ $page->name or 'None' }}
                    </td>
                    <td>
                        <a href="/admin/pages/<?php echo $page->id ?>/edit"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/admin/pages/<?php echo $page->id ?>/confirm"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $pages->links() }}
@endsection