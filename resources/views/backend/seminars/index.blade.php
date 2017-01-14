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
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($seminars->isEmpty())
            <tr>
                <td colspan="8" align="center">There are no seminars.</td>
            </tr>
        @else
            @foreach($seminars as $seminar)
                <tr>
                    <td>
                        {{ $seminar->title }}
                    </td>
                    <td>
                        {{ $seminar->getShortDescription() }}
                    </td>
                    <td>
                        {{ $seminar->maxMembers }}
                    </td>
                    <td>
                        {{ $seminar->duration }} hours
                    </td>
                    <td>
                        {{ $seminar->price }} €
                    </td>
                    <td>
                        <a href="/backend/seminars/<?php echo $seminar->id ?>/detail"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
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