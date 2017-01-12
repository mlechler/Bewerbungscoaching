@extends('layouts.backend')

@section('title', 'Individual Coachings')

@section('content')
    <a href="{{ route('individualcoachings.create') }}" class="btn btn-primary">Create New Coaching</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Employee</th>
            <th>Member</th>
            <th>Date</th>
            <th>Time</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($coachings->isEmpty())
            <tr>
                <td colspan="6" align="center">There are no coachings.</td>
            </tr>
        @else
            @foreach($coachings as $coaching)
                <tr>
                    <td>
                        {{ $coaching->employee->getName() }}
                    </td>
                    <td>
                        {{ $coaching->member->getName() }}
                    </td>
                    <td>
                        {{ $coaching->formatDate() }}
                    </td>
                    <td>
                        {{ $coaching->formatTime() }}
                    </td>
                    <td>
                        <a href="/backend/individualcoachings/<?php echo $coaching->id ?>/edit"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/backend/individualcoachings/<?php echo $coaching->id ?>/confirm"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $coachings->links() }}
@endsection