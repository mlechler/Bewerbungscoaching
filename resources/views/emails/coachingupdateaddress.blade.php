@extends('layouts.email')

@section('content')
    <tr>
        <td align="center">
            <h1>The Individual Coaching was changed!</h1>
        </td>
    </tr>
    <tr>
        <td>
            Hi {{ $coaching->member->firstname }},<br><br>

            <div align="center">
                the address for <strong>{{ $coaching->services }}</strong> on <strong>{{ date_format($coaching->date, 'd.m.Y') }} </strong> has changed. <br>
                Following you can see the changes. <br>
            <br><br>
            Old address:
            <br><br>

                <strong>{{ $oldaddress->zip }} {{ $oldaddress->city }}</strong><br>
                <strong>{{ $oldaddress->street }} {{ $oldaddress->housenumber }}</strong><br>
            <br><br>
            New address:
            <br><br>

                <strong>{{ $coaching->address->zip }}  {{ $coaching->address->city }}</strong><br>
                <strong>{{ $coaching->address->street }}  {{ $coaching->address->housenumber }}</strong><br>
            <br><br>
            Please notice these changes.<br><br>

                If you have received this email incorrectly, please contact us. <br>
                Also for other questions you can write us via this contact form. <br>
                Otherwise we are looking forward and meet you at the individual coaching. <br>
            </div>
            <br><br>
            Best regards, <br>

            <div align="center"><strong>Marcel</strong> from ***</div>
        </td>
    </tr>
@endsection