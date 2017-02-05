@extends('layouts.email')

@section('content')
    <tr>
        <td align="center">
            <h1>The Individual Coaching was cancelled!</h1>
        </td>
    </tr>
    <tr>
        <td>
            Hi {{ $coaching->member->firstname }},<br><br>

            the individual coaching<br><br>

            <div align="center">
                <strong>{{ $coaching->services }}</strong><br>
                <strong>{{ date_format($coaching->date, 'd.m.Y') }}</strong><br>
                <strong>{{ \Carbon\Carbon::parse($coaching->time)->format('H:i') }}
                    - {{ \Carbon\Carbon::parse($coaching->time)->addHours($coaching->duration)->format('H:i') }}</strong>
                @if($coaching->trial)
                    (Trial)
                @endif<br>
                <strong>Employee: {{ $coaching->employee->firstname }} {{ $coaching->employee->lastname }}</strong><br><br>
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