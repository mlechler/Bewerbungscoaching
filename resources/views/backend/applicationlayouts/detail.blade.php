@extends('layouts.backend')

@section('title', 'Details of '.$layout->title)

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Title</h4>
            </td>
            <td>
                <h4>{{ $layout->title }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Preview File</h4>
            </td>
            <td>
                <h4>{{ $layout->getPreviewFilename() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Layout File</h4>
            </td>
            <td>
                <h4>{{ $layout->getLayoutFilename() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Price</h4>
            </td>
            <td>
                <h4>{{ $layout->price }} €</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Description</h4>
            </td>
            <td>
                <h4>{!! $layout->descriptionHtml() !!}</h4>
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('applicationlayouts.index') }}" class="btn btn-danger">Back</a>
@endsection