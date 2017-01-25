@extends('layouts.email')

@section('content')
    <tr>
        <td align="center">
            <h1>You received a Member Discount!</h1>
        </td>
    </tr>
    <tr>
        <td>
            Hi {{ $memberdiscount->member->firstname }},<br><br>

            you received the following member discount:<br><br>

            <div align="center">
                <strong>{{ $memberdiscount->discount->title }}</strong> <br>
                <strong>Services: {{ $memberdiscount->discount->service }}</strong> <br>
                <strong>Amount: {{ $memberdiscount->discount->amount }} {{ $memberdiscount->discount->percentage ? '%' : '€' }}</strong>
                <br>
                <strong>Validity: {{ $memberdiscount->permanent ? 'Permanent' : $memberdiscount->startdate->format('d.m.Y') . ' - ' . $memberdiscount->startdate->addDays($memberdiscount->validity)->format('d.m.Y') }}</strong>
            </div>
            <br><br>


            To use it, enter the code
            <br><br>

            <div align="center">
                <strong>{{ $memberdiscount->code }}</strong>
            </div>

            <br><br>
            in the booking process for the corresponding service.
            <br><br>
            Best regards, <br>

            <div align="center"><strong>Marcel</strong> from ***</div>
        </td>
    </tr>
@endsection