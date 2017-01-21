@extends('layouts.email')

@section('content')
    <tr>
        <td>
            <br>Hi {{ $booking->member->firstname }},<br><br>

            Your Invoice here.
            <br><br>
            Best regards, <br>

            <div align="center"><strong>Marcel</strong> from ***</div>
        </td>
    </tr>
@endsection