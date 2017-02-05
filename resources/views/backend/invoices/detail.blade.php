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
                    <h5>{{ $invoice->booking->formatDate() }}</h5>
                    <h5>{{ $invoice->booking->formatTime() }}</h5>
                @endif
                @if($invoice->individualcoaching)
                    <h4>Individual Coaching</h4>
                    <h5>{{ $invoice->individualcoaching->services }}</h5>
                    <h5>{{ $invoice->individualcoaching->formatDate() }}</h5>
                    <h5>{{ $invoice->individualcoaching->formatTime() }}</h5>
                @endif
                @if($invoice->packagepurchase)
                    <h4>Application Package</h4>
                    <h5>{{ $invoice->packagepurchase->applicationpackage->title }}</h5>
                @endif
                @if($invoice->layoutpurchase)
                    <h4>Application Layout</h4>
                    <h5>{{ $invoice->layoutpurchase->applicationlayout->title }}</h5>
                @endif
            </td>
        </tr>
        <tr>
            <td>
                <h4>Total Price</h4>
            </td>
            <td>
                <h4>{{ $invoice->totalprice }} €</h4>
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