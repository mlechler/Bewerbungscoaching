@extends('layouts.frontend')

@section('title', 'Bank Contact')

@section('content')
    Please transfer the amount of <strong>{{ $price_incl_discount }} €</strong> to the following bank account. <br>
    Please use <strong>{{ $invoice_id }}</strong> as the subject. <br><br>

    <strong>Bank Account:</strong><br><br>
    <div class="row">
        <div class="col-md-2">
            <strong>Bank:</strong><br>
            <strong>Bank Code:</strong><br>
            <strong>Account Number:</strong><br>
            <strong>IBAN:</strong><br>
            <strong>BIC:</strong><br>
            <strong>UID:</strong><br>
            <strong>Tax Number:</strong><br>
        </div>
        <div class="col-md-2">
            ***<br>
            ***<br>
            ***<br>
            ***<br>
            ***<br>
            ***<br>
            ***<br>
        </div>
    </div>
@endsection