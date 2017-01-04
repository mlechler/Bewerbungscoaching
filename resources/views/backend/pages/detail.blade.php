@extends('layouts.backend')

@section('title', 'Details of '.$page->title)

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Title</h4>
            </td>
            <td>
                <h4>{{ $page->title }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>URI</h4>
            </td>
            <td>
                <h4>{{ $page->uri }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Name</h4>
            </td>
            <td>
                <h4>{{ $page->name }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Template</h4>
            </td>
            <td>
                <h4>{{ $page->template }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Content</h4>
            </td>
            <td>
                <h4>{{ $page->pagecontent }}</h4>
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('pages.index') }}" class="btn btn-danger">Back</a>
@endsection