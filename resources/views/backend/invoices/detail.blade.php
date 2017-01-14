@extends('layouts.backend')

@section('title', 'Details of Invoice No.'.$invoice->id)

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Member</h4>
            </td>
            <td>
                <h4>{{ $invoice->member->getName() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Content</h4>
            </td>
            <td>
                @if($invoice->booking)
                    <h4>Seminarbooking</h4>
                    <h5>{{ $invoice->booking->appointment->seminar->title}}</h5>
                    <h5>{{ $invoice->booking->appointment->date }}</h5>
                    <h5>{{ $invoice->booking->appointment->time }}</h5>
                @endif
                @if($invoice->individualcoaching)
                    <h4>Individual Coaching</h4>
                    <h5>{{ $invoice->individualcoaching->services }}</h5>
                    <h5>{{ $invoice->individualcoaching->date }}</h5>
                    <h5>{{ $invoice->individualcoaching->time }}</h5>
                @endif
            </td>
        </tr>
        <tr>
            <td>
                <h4>Total Price</h4>
            </td>
            <td>
                @if($invoice->booking)
                    <h4>{{ $invoice->booking->price_incl_discount }} €</h4>
                @endif
                @if($invoice->individualcoaching)
                    <h4>{{ $invoice->individualcoaching->price_incl_discount }} €</h4>
                @endif
            </td>
        </tr>
        <tr>
            <td>
                <h4>Date</h4>
            </td>
            <td>
                <h4>{{ $invoice->formatDate() }}</h4>
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('invoices.index') }}" class="btn btn-danger">Back</a>
@endsection