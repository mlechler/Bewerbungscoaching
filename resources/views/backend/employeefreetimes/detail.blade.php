@extends('layouts.backend')

@section('title', 'Details of VALUE')

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Employee</h4>
            </td>
            <td>
                <h4>{{ $freetime->employee->getName() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Hourly Rate</h4>
            </td>
            <td>
                <h4>{{ $freetime->hourlyrate }} €</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Services</h4>
            </td>
            <td>
                <h4>{{ $freetime->services }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Date</h4>
            </td>
            <td>
                <h4>{{ $freetime->formatDate() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Time</h4>
            </td>
            <td>
                <h4>{{ $freetime->formatTime() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Address</h4>
            </td>
            <td>
                <h4>{{ $freetime->formatAddress() }}</h4>
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('employeefreetimes.index') }}" class="btn btn-danger">Back</a>
@endsection