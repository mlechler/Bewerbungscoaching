@extends('layouts.backend')

@section('title', 'Details of VALUE')

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Seminar</h4>
            </td>
            <td>
                <h4>{{ $seminarappointment->seminar->title }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Employee</h4>
            </td>
            <td>
                <h4>{{ $seminarappointment->employee->getName() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Address</h4>
            </td>
            <td>
                <h4>{{ $seminarappointment->formatAddress() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Date</h4>
            </td>
            <td>
                <h4>{{ $seminarappointment->formatDate() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Time</h4>
            </td>
            <td>
                <h4>{{ $seminarappointment->formatTime() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Participants</h4>
            </td>
            <td>
                @foreach($seminarappointment->members as $member)
                    <div class="row">
                        <div class="col-md-3">
                            {{ $member->getName() }}
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('seminarappointments.removeParticipant', [$seminarappointment->id, $member->id]) }}"><span
                                        class="glyphicon glyphicon-remove"></span></a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('seminarappointments.participantPaid', [$seminarappointment->id, $member->id]) }}"><span
                                        class="glyphicon glyphicon-ok"></span></a>
                        </div>
                        <div class="col-md-2">
                            {{ $member->pivot->paid ? 'Paid' : 'Not Paid' }}
                        </div>
                    </div>
                @endforeach
                    <br><br><br>
                    <a href="{{ route('seminarappointments.list', $seminarappointment->id) }}" class="btn btn-success">Create List</a>
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('seminarappointments.index') }}" class="btn btn-danger">Back</a>
@endsection