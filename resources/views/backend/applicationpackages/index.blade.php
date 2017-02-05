@extends('layouts.backend')

@section('title', 'Application Packages')

@section('content')
    <a href="{{ route('applicationpackages.create') }}" class="btn btn-primary">Create New Application Package</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($packages->isEmpty())
            <tr>
                <td colspan="6" align="center">There are no application packages.</td>
            </tr>
        @else
            @foreach($packages as $package)
                <tr>
                    <td>
                        {{ $package->title }}
                    </td>
                    <td>
                        {!! $package->getShortDescription() !!}
                    </td>
                    <td>
                        {{ $package->price }} €
                    </td>
                    <td>
                        <a href="{{ route('applicationpackages.detail', $package->id) }}"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
                    </td>
                    <td>
                        <a href="{{ route('applicationpackages.edit', $package->id) }}"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="{{ route('applicationpackages.confirm', $package->id) }}"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $packages->links() }}
@endsection