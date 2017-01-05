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
                <h4>Adress</h4>
            </td>
            <td>
                <h4>{{ $seminarappointment->formatAdress($seminarappointment->adress) }}</h4>
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
                <h4>VALUE</h4>
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('seminarappointments.index') }}" class="btn btn-danger">Back</a>
@endsection