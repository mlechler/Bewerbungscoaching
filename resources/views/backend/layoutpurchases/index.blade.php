@extends('layouts.backend')

@section('title', 'Layout Purchases')

@section('content')
    <a href="{{ route('layoutpurchases.create') }}" class="btn btn-primary">Create New Layout Purchase</a>
    {{ Form::open() }}
    <div class="form-group has-feedback has-feedback-left">
        <br>
        {{ Form::text('searchInput', null, ['class' => 'form-control', 'id' => 'searchInput', 'onkeyup' => 'search()', 'placeholder' => 'Search for Member or Layout']) }}
        <i class="form-control-feedback glyphicon glyphicon-search"></i>
    </div>
    {{ Form::close() }}
    <table class="table table-hover" id="layoutpurchaseTable">
        <thead>
        <tr>
            <th>Member</th>
            <th>Layout</th>
            <th>Price</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($layoutpurchases->isEmpty())
            <tr>
                <td colspan="6" align="center">There are no layout purchases.</td>
            </tr>
        @else
            @foreach($layoutpurchases as $layoutpurchase)
                <tr>
                    <td>
                        {{ $layoutpurchase->member->getName() }}
                    </td>
                    <td>
                        {{ $layoutpurchase->applicationlayout->title }}
                    </td>
                    <td>
                        {{ $layoutpurchase->price_incl_discount }} €
                    </td>
                    <td>
                        <a href="/backend/layoutpurchases/<?php echo $layoutpurchase->id ?>/detail"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
                    </td>
                    <td>
                        <a href="/backend/layoutpurchases/<?php echo $layoutpurchase->id ?>/edit"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/backend/layoutpurchases/<?php echo $layoutpurchase->id ?>/confirm"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $layoutpurchases->links() }}

    <script>
        function search() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("layoutpurchaseTable");
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