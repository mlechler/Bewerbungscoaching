@extends('layouts.email')

@section('content')
    <tr>
        <td align="right" colspan="2">
            <p>
                <strong>
                    Bewerbungscoaching <br>
                    Musterstr. 35 <br>
                    D-12345 Musterstadt <br>
                </strong>
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <p style="font-size: 11px">
                Bewerbungscoaching, Musterstr. 35, 12345 Musterstadt
            </p>

            <p>
                {{ $booking->member->firstname }} {{ $booking->member->lastname }}<br>
                {{ $booking->member->adress->street }} {{ $booking->member->adress->housenumber }}<br><br>

                <strong>D-{{ $booking->member->adress->zip }} {{ $booking->member->adress->city }}</strong>
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <br><br><br>
        </td>
    </tr>
    <tr>
        <td>
            Invoice No. {{ $invoice->id }}
        </td>
        <td align="right">
            {{ date_format($invoice->date, 'd.m.Y') }}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <br><strong>Hi {{ $booking->member->firstname }},</strong><br>
            According to your booking we calculate the following order:
        <td>
    </tr>
    <tr>
        <td colspan="2" align="right">
            <strong>Customer ID: {{ $booking->member->id }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table cellpadding="0" cellspacing="0" border="0" width="600px">
                <tr>
                    <td colspan="6">
                        <hr size="1">
                    </td>
                </tr>
                <tr style="font-size: 11px">
                    <td width="10%">
                        <strong>Pos</strong>
                    </td>
                    <td width="42%">
                        <strong>Description</strong>
                    </td>
                    <td width="12%" align="right">
                        <strong>VAT</strong>
                    </td>
                    <td width="12%" align="right">
                        <strong>Discount</strong>
                    </td>
                    <td width="12%" align="right">
                        <strong>Price</strong>
                    </td>
                    <td width="12%" align="right">
                        <strong>Total</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <hr size="1">
                    </td>
                </tr>
                <tr style="font-size: 11px">
                    <td>
                        1
                    </td>
                    <td>
                        {{ $booking->appointment->seminar->title }}
                        , {{ date_format($booking->appointment->date, 'd.m.Y') }}
                        , {{ \Carbon\Carbon::parse($booking->appointment->time)->format('H:i') }}
                        - {{ \Carbon\Carbon::parse($booking->appointment->time)->addHours($booking->appointment->seminar->duration)->format('H:i') }}
                    </td>
                    <td align="right">
                        19 %
                    </td>
                    <td align="right"> <!-- If Member enters a discount use this, if Employee enters in Backend calculate, otherwise null -->
                        {{ $discount = 100 - round(($booking->price_incl_discount * 100) / $booking->appointment->seminar->price) }} %
                    </td>
                    <td align="right">
                        {{ $booking->appointment->seminar->price }} €
                    </td>
                    <td align="right"> <!-- If Member enters a discount calculate, if Employee enters use this-->
                        {{--{{ round(($booking->appointment->seminar->price * (100 - $discount)) / 100, 2) }} €--}}
                        {{ $booking->price_incl_discount }}
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <hr size="1">
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="right">
                        Price
                    </td>
                    <td colspan="2" align="right">
                        {{ $booking->appointment->seminar->price }} €
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="right">
                        Discount
                    </td>
                    <td colspan="2" align="right"> <!-- If Member enters a discount use this, if Employee enters calculate, otherwise null-->
                        {{ $booking->appointment->seminar->price - $booking->price_incl_discount }} €
                    </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="4">
                        <hr size="1">
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="right">
                        <strong>Total</strong>
                    </td>
                    <td colspan="2" align="right"> <!-- If Member enters a discount calculate, if Employee enters use this-->
                        <strong>{{ $booking->price_incl_discount }} €</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="4">
                        <hr size="1">
                    </td>
                </tr>
                <tr style="font-size: 11px">
                    <td colspan="4" align="right">
                        Total without VAT
                    </td>
                    <td colspan="2" align="right">
                        {{ $price_without_vat = $booking->price_incl_discount * 0.81 }} €
                    </td>
                </tr>
                <tr style="font-size: 11px">
                    <td colspan="4" align="right">
                        VAT
                    </td>
                    <td colspan="2" align="right">
                        {{ $booking->price_incl_discount - $price_without_vat }} €
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <br><br>
            This invoice is part of your order from {{ date_format($invoice->date, 'd.m.Y, H:i') }}. <br>
            Please pay this amount within the next fourteen days to the bank account below. <br><br>

            <div align="center">
                If you have received this invoice incorrectly, please contact us. <br>
                Also for other questions you can write us via this contact form. <br>
            </div>
            <br><br>
            Best regards, <br>

            <div align="center"><strong>Marcel</strong> from ***</div>
            <br><br>

            <p>
                <strong>Bank Account:</strong><br>
                Bank: ***, Bank Code: ***, Account Number: ***, IBAN: ***, BIC: ***<br>
                UID: ***, Tax Number: ***
            </p>
        </td>
    </tr>
@endsection