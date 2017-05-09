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
                {{ $packagepurchase->member->firstname }} {{ $packagepurchase->member->lastname }}<br>
                {{ $packagepurchase->member->address->street }} {{ $packagepurchase->member->address->housenumber }}<br><br>

                <strong>D-{{ $packagepurchase->member->address->zip }} {{ $packagepurchase->member->address->city }}</strong>
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
            <br><strong>Hi {{ $packagepurchase->member->firstname }},</strong><br>
            According to your purchase we calculate the following order:
        <td>
    </tr>
    <tr>
        <td colspan="2" align="right">
            <strong>Customer ID: {{ $packagepurchase->member->id }}</strong>
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
                        <strong>Application Package</strong><br>
                        {{ $packagepurchase->applicationpackage->title }}
                    </td>
                    <td align="right">
                        19 %
                    </td>
                    <td align="right">
                        <!-- If Member enters a discount use this, if Employee enters in Backend calculate, otherwise null -->
                        {{ $discount = 100 - round(($packagepurchase->price_incl_discount * 100) / $packagepurchase->applicationpackage->price) }}
                        %
                    </td>
                    <td align="right">
                        {{ number_format($packagepurchase->applicationpackage->price,2) }} €
                    </td>
                    <td align="right"> <!-- If Member enters a discount calculate, if Employee enters use this-->
                        {{--{{ round(($booking->appointment->seminar->price * (100 - $discount)) / 100, 2) }} €--}}
                        {{ number_format($packagepurchase->price_incl_discount,2) }} €
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
                        {{ number_format($packagepurchase->applicationpackage->price,2) }} €
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="right">
                        Discount
                    </td>
                    <td colspan="2" align="right">
                        <!-- If Member enters a discount use this, if Employee enters calculate, otherwise null-->
                        {{ number_format($packagepurchase->price_incl_discount - $packagepurchase->applicationpackage->price,2) }} €
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
                    <td colspan="2" align="right">
                        <!-- If Member enters a discount calculate, if Employee enters use this-->
                        <strong>{{ number_format($packagepurchase->price_incl_discount,2) }} €</strong>
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
                        {{ $price_without_vat = round($packagepurchase->price_incl_discount * 0.81,2) }} €
                    </td>
                </tr>
                <tr style="font-size: 11px">
                    <td colspan="4" align="right">
                        VAT
                    </td>
                    <td colspan="2" align="right">
                        {{ number_format($packagepurchase->price_incl_discount - $price_without_vat,2) }} €
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <br><br>
            This invoice is part of your order from {{ date_format($invoice->date, 'd.m.Y, H:i') }}. <br>
            Please pay this amount within the next fourteen days to the bank account below. Use <strong>{{ $invoice->id }}</strong> as the subject.
            If you paid with PayPal no further action is required.<br><br>

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