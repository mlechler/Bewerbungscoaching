@extends('layouts.email')

@section('content')
    <tr>
        <td align="center">
            <h1>Your Member Discount expired!</h1>
        </td>
    </tr>
    <tr>
        <td>
            Hi {{ $memberdiscount->member->firstname }},<br><br>

           unfortunately your member discount <strong>{{ $memberdiscount->discount->title }}</strong> expired.
            <br><br>

            The code
            <br><br>

            <div align="center">
                <strong>{{ $memberdiscount->code }}</strong>
            </div>

            <br><br>
            is not usable anymore.
            <br><br>
            Best regards, <br>

            <div align="center"><strong>Marcel</strong> from ***</div>
        </td>
    </tr>
@endsection