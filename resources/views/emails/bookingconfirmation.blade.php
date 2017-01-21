@extends('layouts.email')

@section('content')
    <tr>
        <td align="center">
            <h1>Your Booking was successful!</h1>
        </td>
    </tr>
    <tr>
        <td>
            Hi {{ $booking->member->firstname }},<br><br>

            <div align="center">
                your booking for a seminar from our company was successful. <br>
                In the near future you will get an email with the corresponding invoice. <br>
            </div>
            <br><br>
            Your booking in a short overview:
            <br><br>

            <div align="center">
                <strong>{{ $booking->appointment->seminar->title }}</strong><br>
                <strong>{{ date_format($booking->appointment->date, 'd.m.Y') }}</strong><br>
                <strong>{{ \Carbon\Carbon::parse($booking->appointment->time)->format('H:i') }}
                    - {{ \Carbon\Carbon::parse($booking->appointment->time)->addHours($booking->appointment->seminar->duration)->format('H:i') }}</strong><br>
            </div>
            <br><br>

            <div align="center">
                If you have received this booking incorrectly, please contact us. <br>
                Also for other questions you can write us via this contact form. <br>
                Otherwise we are looking forward and meet you at the seminar. <br>
            </div>
            <br><br>
            Best regards, <br>

            <div align="center"><strong>Marcel</strong> from ***</div>
        </td>
    </tr>
@endsection