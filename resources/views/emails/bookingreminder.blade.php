@extends('layouts.email')

@section('content')
    <tr>
        <td align="center">
            <h1>Don't forget your Booking!</h1>
        </td>
    </tr>
    <tr>
        <td>
            Hi {{ $booking->member->firstname }},<br><br>

            <div align="center">
                this is a friendly reminder for your booking at our company. <br>
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
            The address for this seminar is:<br><br>

            <div align="center">
                <strong>{{ $booking->appointment->address->zip }}  {{ $booking->appointment->address->city }}</strong><br>
                <strong>{{ $booking->appointment->address->street }}  {{ $booking->appointment->address->housenumber }}</strong><br><br>
            </div>

            <div align="center">
                If you have received this reminder incorrectly, please contact us. <br>
                Also for other questions you can write us via this contact form. <br>
                Otherwise we are looking forward and meet you at the seminar. <br>
            </div>
            <br><br>
            Best regards, <br>

            <div align="center"><strong>Marcel</strong> from ***</div>
        </td>
    </tr>
@endsection