@extends('layouts.email')

@section('content')
    <tr>
        <td align="center">
            <h1>The Appointment was cancelled!</h1>
        </td>
    </tr>
    <tr>
        <td>
            Hi {{ $participant->firstname }},<br><br>

            the appointment<br><br>

            <div align="center">
                <strong>{{ $seminarappointment->seminar->title }}</strong> <br>
                <strong>{{ date_format($seminarappointment->date, 'd.m.Y') }}</strong> <br>
                <strong>{{ \Carbon\Carbon::parse($seminarappointment->time)->format('H:i') }}
                    - {{ \Carbon\Carbon::parse($seminarappointment->time)->addHours($seminarappointment->seminar->duration)->format('H:i') }}</strong>
                <br><br>
            </div>
            has been cancelled.
            <br><br>

            <div align="center">
                Please notice this cancellation.<br><br>

                If you have received this email incorrectly, please contact us. <br>
                Also for other questions you can write us via this contact form. <br>
                Otherwise we are looking forward and meet you at the seminar. <br>
            </div>
            <br><br>
            Best regards, <br>

            <div align="center"><strong>Marcel</strong> from ***</div>
        </td>
    </tr>
@endsection