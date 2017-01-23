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
                <h4>{{ $coaching->employee->getName() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Member</h4>
            </td>
            <td>
                <h4>{{ $coaching->member->getName() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Services</h4>
            </td>
            <td>
                <h4>{{ $coaching->services }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Date</h4>
            </td>
            <td>
                <h4>{{ $coaching->formatDate() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Time</h4>
            </td>
            <td>
                <h4>{{ $coaching->formatTime() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Adress</h4>
            </td>
            <td>
                <h4>{{ $coaching->formatAdress() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Price</h4>
            </td>
            <td>
                <h4>{{ $coaching->price_incl_discount }} €</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Paid</h4>
            </td>
            <td>
                <h4><span class="glyphicon glyphicon-{{ $coaching->paid ? 'ok' : 'remove' }}"></span></h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Trial</h4>
            </td>
            <td>
                <h4><span class="glyphicon glyphicon-{{ $coaching->trial ? 'ok' : 'remove' }}"></span></h4>
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('individualcoachings.index') }}" class="btn btn-danger">Back</a>
@endsection