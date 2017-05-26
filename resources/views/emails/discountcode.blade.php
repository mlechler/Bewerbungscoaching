@extends('layouts.email')

@section('content')
    <tr>
        <td align="center">
            <h1>You received a Discount!</h1>
        </td>
    </tr>
    <tr>
        <td>
            Hi,<br><br>

            you received the following discount:<br><br>

            <div align="center">
                <strong>{{ $discount->title }}</strong> <br>
                <strong>Services: {{ $discount->service }}</strong> <br>
                <strong>Amount: {{ $discount->amount }} {{ $discount->percentage ? '%' : '€' }}</strong>
                <br>
                <strong>Validity: {{ $discount->permanent ? 'Permanent' : $discount->startdate->format('d.m.Y') . ' - ' . $discount->startdate->addDays($memberdiscount->validity)->format('d.m.Y') }}</strong>
            </div>
            <br><br>


            To use it, enter the code
            <br><br>

            <div align="center">
                <strong>{{ $discount->code }}</strong>
            </div>

            <br><br>
            in the booking process for the corresponding service.
            <br><br>
            Best regards, <br>

            <div align="center"><strong>Marcel</strong> from ***</div>
        </td>
    </tr>
@endsection