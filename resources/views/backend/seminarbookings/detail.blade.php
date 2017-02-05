@extends('layouts.backend')

@section('title', 'Details of VALUE')

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Member</h4>
            </td>
            <td>
                <h4>{{ $seminarbooking->member->getName() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Appointment</h4>
            </td>
            <td>
                <h4>{{ $seminarbooking->appointment->seminar->title }}</h4>
                <h4>{{ $seminarbooking->formatDate() }}</h4>
                <h4>{{ $seminarbooking->formatTime() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Price</h4>
            </td>
            <td>
                <h4>{{ $seminarbooking->price_incl_discount }} €</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Paid</h4>
            </td>
            <td>
                <h4><span class="glyphicon glyphicon-{{ $seminarbooking->paid ? 'ok' : 'remove' }}"></span></h4>
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('seminarbookings.index') }}" class="btn btn-danger">Back</a>
@endsection