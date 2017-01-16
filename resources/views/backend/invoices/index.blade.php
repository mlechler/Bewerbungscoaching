@extends('layouts.backend')

@section('title', 'Invoices')

@section('content')
    <a href="{{ route('invoices.create') }}" class="btn btn-primary">Create New Invoice</a>
    {{ Form::open() }}
    <div class="form-group has-feedback has-feedback-left">
        <br>
        {{ Form::text('searchInput', null, ['class' => 'form-control', 'id' => 'searchInput', 'onkeyup' => 'search()', 'placeholder' => 'Search for Member or Date']) }}
        <i class="form-control-feedback glyphicon glyphicon-search"></i>
    </div>
    {{ Form::close() }}
    <table class="table table-hover" id="invoiceTable">
        <thead>
        <tr>
            <th>Member</th>
            <th>Date</th>
            <th>Total Price</th>
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
                        {{ $invoice->formatDate() }}
                    </td>
                    <td>
                        {{ $invoice->totalprice }} €
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

    <script>
        function search() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("invoiceTable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        td = tr[i].getElementsByTagName("td")[1];
                        if (td) {
                            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            }
        }
    </script>
@endsection