@extends('layouts.email')

@section('content')
    <tr>
        <td align="center">
            <h1>Your Purchase was successful!</h1>
        </td>
    </tr>
    <tr>
        <td>
            Hi {{ $layoutpurchase->member->firstname }},<br><br>

            <div align="center">
                your purchase for an application layout from our company was successful. <br>
                In the near future you will get an email with the corresponding invoice. <br>
            </div>
            <br><br>
            Your purchase in a short overview:
            <br><br>

            <div align="center">
                <strong>{{ $layoutpurchase->applicationlayout->title }}</strong><br>
            </div>
            <br><br>

            <div align="center">
                If you have received this purchase incorrectly, please contact us. <br>
                Also for other questions you can write us via this contact form. <br>
            </div>
            <br><br>
            Best regards, <br>

            <div align="center"><strong>Marcel</strong> from ***</div>
        </td>
    </tr>
@endsection