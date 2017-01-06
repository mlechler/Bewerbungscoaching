@extends('layouts.backend')

@section('title', 'Seminars')

@section('content')
    <a href="{{ route('seminars.create') }}" class="btn btn-primary">Create New Seminar</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Maximum Participants</th>
            <th>Duration</th>
            <th>Price</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($seminars->isEmpty())
            <tr>
                <td colspan="7" align="center">There are no seminars.</td>
            </tr>
        @else
            @foreach($seminars as $seminar)
                <tr>
                    <td>
                        <a href="/backend/seminars/<?php echo $seminar->id ?>/detail">{{ $seminar->title }}</a>
                    </td>
                    <td>
                        {{ $seminar->getShortDescription($seminar->description) }}
                    </td>
                    <td>
                        {{ $seminar->maxMembers }}
                    </td>
                    <td>
                        {{ $seminar->duration }} minutes
                    </td>
                    <td>
                        {{ $seminar->price }} €
                    </td>
                    <td>
                        <a href="/backend/seminars/<?php echo $seminar->id ?>/edit"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/backend/seminars/<?php echo $seminar->id ?>/confirm"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $seminars->links() }}
@endsection