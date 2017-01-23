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
                the adress for <strong>{{ $seminarappointment->seminar->title }}</strong> has changed. <br>
                Following you can see the changes. <br>
            <br><br>
            Old adress:
            <br><br>

                <strong>{{ $oldadress->zip }} {{ $oldadress->city }}</strong><br>
                <strong>{{ $oldadress->street }} {{ $oldadress->housenumber }}</strong><br>
            <br><br>
            New adress:
            <br><br>

                <strong>{{ $seminarappointment->adress->zip }}  {{ $seminarappointment->adress->city }}</strong><br>
                <strong>{{ $seminarappointment->adress->street }}  {{ $seminarappointment->adress->housenumber }}</strong><br>
            <br><br>
            Please notice this changes.<br><br>

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