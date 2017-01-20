@extends('layouts.email')

@section('content')
    <tr style="align-content: center">
        <td width="600px" >
            <h1>Your Booking was successful!</h1>
        </td>
    </tr>
    <tr>
        <td>
            You booked:<br>
            {{ $booking->appointment->seminar->title }}<br>
            {{ $booking->appointment->date }}<br>
            {{ $booking->appointment->time }}<br>
        </td>
    </tr>
@endsection