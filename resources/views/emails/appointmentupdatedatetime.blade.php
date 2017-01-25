@extends('layouts.email')

@section('content')
    <tr>
        <td align="center">
            <h1>The Appointment was changed!</h1>
        </td>
    </tr>
    <tr>
        <td>
            Hi {{ $participant->firstname }},<br><br>

            <div align="center">
                the date for <strong>{{ $seminarappointment->seminar->title }}</strong> has changed. <br>
                Following you can see the changes. <br>
            <br><br>
            Old date:
            <br><br>

                <strong>{{ date_format($olddate, 'd.m.Y') }}</strong><br>
                <strong>{{ $oldtime }}
                    - {{ \Carbon\Carbon::parse($oldtime)->addHours($seminarappointment->seminar->duration)->format('H:i') }}</strong><br>
            <br><br>
            New date:
            <br><br>

                <strong>{{ date_format($seminarappointment->date, 'd.m.Y') }}</strong><br>
                <strong>{{ \Carbon\Carbon::parse($seminarappointment->time)->format('H:i') }}
                    - {{ \Carbon\Carbon::parse($seminarappointment->time)->addHours($seminarappointment->seminar->duration)->format('H:i') }}</strong><br>
            <br><br>
            Please notice these changes.<br><br>

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