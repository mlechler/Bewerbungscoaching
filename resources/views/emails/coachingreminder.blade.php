@extends('layouts.email')

@section('content')
    <tr>
        <td align="center">
            <h1>Don't forget your Booking!</h1>
        </td>
    </tr>
    <tr>
        <td>
            Hi {{ $coaching->member->firstname }},<br><br>

            <div align="center">
                this is a friendly reminder for your booking at our company. <br>
            </div>
            <br><br>
            Your booking in a short overview:
            <br><br>

            <div align="center">
                <strong>{{ $coaching->services }}</strong><br>
                <strong>{{ date_format($coaching->date, 'd.m.Y') }}</strong><br>
                <strong>{{ \Carbon\Carbon::parse($coaching->time)->format('H:i') }}
                    - {{ \Carbon\Carbon::parse($coaching->time)->addHours($coaching->duration)->format('H:i') }}</strong>
            @if($coaching->trial)
                    (Trial)
                @endif<br>
                <strong>Employee: {{ $coaching->employee->firstname }} {{ $coaching->employee->lastname }}</strong><br>
            </div>
            <br><br>
            The address for this individual coaching is:<br><br>

            <div align="center">
                <strong>{{ $coaching->address->zip }}  {{ $coaching->address->city }}</strong><br>
                <strong>{{ $coaching->address->street }}  {{ $coaching->address->housenumber }}</strong><br><br>
            </div>

            <div align="center">
                If you have received this reminder incorrectly, please contact us. <br>
                Also for other questions you can write us via this contact form. <br>
                Otherwise we are looking forward and meet you at the individual coaching. <br>
            </div>
            <br><br>
            Best regards, <br>

            <div align="center"><strong>Marcel</strong> from ***</div>
        </td>
    </tr>
@endsection