@extends('layouts.backend')

@section('title', 'Employee Free Times')

@section('content')
    <a href="{{ route('employeefreetimes.create') }}" class="btn btn-primary">Create New Free Time</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($freetimes->isEmpty())
            <tr>
                <td colspan="6" align="center">There are no free times.</td>
            </tr>
        @else
        @foreach($freetimes as $freetime)
            <tr>
                <td>
                    {{ $freetime->employee->getName() }}
                </td>
                <td>
                    {{ $freetime->formatDate() }}
                </td>
                <td>
                    {{ $freetime->formatTime() }}
                </td>
                <td>
                    <a href="{{ route('employeefreetimes.detail', $freetime->id) }}"><span
                                class="glyphicon glyphicon-info-sign"></span></a>
                </td>
                <td>
                    <a href="{{ route('employeefreetimes.edit', $freetime->id) }}"><span
                                class="glyphicon glyphicon-edit"></span></a>
                </td>
                <td>
                    <a href="{{ route('employeefreetimes.confirm', $freetime->id) }}"><span
                                class="glyphicon glyphicon-remove"></span></a>
                </td>
            </tr>
        @endforeach
            @endif
        </tbody>
    </table>

    {{ $freetimes->links() }}
@endsection