@extends('layouts.backend')

@section('title', 'Appointments')

@section('content')
    <a href="{{ route('seminarappointments.create') }}" class="btn btn-primary">Create New Appointment</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Seminar</th>
            <th>Employee</th>
            <th>Date</th>
            <th>Time</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($seminarappointments->isEmpty())
            <tr>
                <td colspan="6" align="center">There are no appointments.</td>
            </tr>
        @else
            @foreach($seminarappointments as $appointment)
                <tr>
                    <td>
                        <a href="/backend/seminarappointments/<?php echo $appointment->id ?>/detail">{{ $appointment->seminar->title }}</a>
                    </td>
                    <td>
                        {{ $appointment->employee->getName() }}
                    </td>
                    <td>
                        {{ $appointment->date }}
                    </td>
                    <td>
                        {{ $appointment->time }}
                    </td>
                    <td>
                        <a href="/backend/seminarappointments/<?php echo $appointment->id ?>/edit"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/backend/seminarappointments/<?php echo $appointment->id ?>/confirm"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $seminarappointments->links() }}
@endsection