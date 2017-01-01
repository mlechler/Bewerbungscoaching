@extends('layouts.backend')

@section('title', 'Pages')

@section('content')
    <a href="{{ route('pages.create') }}" class="btn btn-primary">Create New Page</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>URI</th>
            <th>Name</th>
            <th>Template</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($pages->isEmpty())
            <tr>
                <td colspan="6" align="center">There are no pages.</td>
            </tr>
        @else
            @foreach($pages as $page)
                <tr>
                    <td>
                        {{ $page->linkToPaddedTitle() }}
                    </td>
                    <td>
                        <a href="{{ url($page->uri) }}">{{ $page->prettyURI() }}</a>
                    </td>
                    <td>
                        {{ $page->name or 'None' }}
                    </td>
                    <td>
                        {{ $page->template or 'None' }}
                    </td>
                    <td>
                        <a href="/backend/pages/<?php echo $page->id ?>/edit"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/backend/pages/<?php echo $page->id ?>/confirm"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $pages->links() }}
@endsection