@extends('layouts.backend')

@section('title', 'Application Layouts')

@section('content')
    <a href="{{ route('applicationlayouts.create') }}" class="btn btn-primary">Create New Application Layout</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>Preview / Layout</th>
            <th>Price</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($layouts->isEmpty())
            <tr>
                <td colspan="6" align="center">There are no application layouts.</td>
            </tr>
        @else
            @foreach($layouts as $layout)
                <tr>
                    <td>
                        {{ $layout->title }}
                    </td>
                    <td>
                        {{ $layout->getFilenames() }}
                    </td>
                    <td>
                        {{ $layout->price }} €
                    </td>
                    <td>
                        <a href="{{ route('applicationlayouts.detail', $layout->id) }}"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
                    </td>
                    <td>
                        <a href="{{ route('applicationlayouts.edit', $layout->id) }}"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="{{ route('applicationlayouts.confirm', $layout->id) }}"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $layouts->links() }}
@endsection