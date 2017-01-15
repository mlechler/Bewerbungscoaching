@extends('layouts.backend')

@section('title', 'Bookings')

@section('content')
    <a href="{{ route('seminarbookings.create') }}" class="btn btn-primary">Create New Booking</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Member</th>
            <th>Appointment</th>
            <th>Price</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($seminarbookings->isEmpty())
            <tr>
                <td colspan="5" align="center">There are no appointments.</td>
            </tr>
        @else
            @foreach($seminarbookings as $booking)
                <tr>
                    <td>
                        {{ $booking->member->getName() }}
                    </td>
                    <td>
                        {{ $booking->getAppointment() }}
                    </td>
                    <td>
                        {{ $booking->price_incl_discount }} €
                    </td>
                    <td>
                        <a href="/backend/seminarbookings/<?php echo $booking->id ?>/detail"><span
                                    class="glyphicon glyphicon-info-sign"></span>
                    </td>
                    <td>
                        <a href="/backend/seminarbookings/<?php echo $booking->id ?>/edit"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/backend/seminarbookings/<?php echo $booking->id ?>/confirm"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $seminarbookings->links() }}
@endsection