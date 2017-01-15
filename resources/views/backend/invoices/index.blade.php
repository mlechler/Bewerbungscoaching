@extends('layouts.backend')

@section('title', 'Invoices')

@section('content')
    <a href="{{ route('invoices.create') }}" class="btn btn-primary">Create New Invoice</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Member</th>
            <th>Total Price</th>
            <th>Date</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($invoices->isEmpty())
            <tr>
                <td colspan="6" align="center">There are no invoices.</td>
            </tr>
        @else
            @foreach($invoices as $invoice)
                <tr>
                    <td>
                        {{ $invoice->member->getName() }}
                    </td>
                    <td>
                        {{ $invoice->totalprice }} €
                    </td>
                    <td>
                        {{ $invoice->formatDate() }}
                    </td>
                    <td>
                        <a href="/backend/invoices/<?php echo $invoice->id ?>/detail"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
                    </td>
                    <td>
                        <a href="/backend/invoices/<?php echo $invoice->id ?>/edit"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/backend/invoices/<?php echo $invoice->id ?>/confirm"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $invoices->links() }}
@endsection