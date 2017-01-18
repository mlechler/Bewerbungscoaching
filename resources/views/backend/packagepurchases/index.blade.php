@extends('layouts.backend')

@section('title', 'Package Purchases')

@section('content')
    <a href="{{ route('packagepurchases.create') }}" class="btn btn-primary">Create New Package Purchase</a>
    {{ Form::open() }}
    <div class="form-group has-feedback has-feedback-left">
        <br>
        {{ Form::text('searchInput', null, ['class' => 'form-control', 'id' => 'searchInput', 'onkeyup' => 'search()', 'placeholder' => 'Search for Member or Package']) }}
        <i class="form-control-feedback glyphicon glyphicon-search"></i>
    </div>
    {{ Form::close() }}
    <table class="table table-hover" id="packagepurchaseTable">
        <thead>
        <tr>
            <th>Member</th>
            <th>Package</th>
            <th>Price</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($packagepurchases->isEmpty())
            <tr>
                <td colspan="6" align="center">There are no package purchases.</td>
            </tr>
        @else
            @foreach($packagepurchases as $packagepurchase)
                <tr>
                    <td>
                        {{ $packagepurchase->member->getName() }}
                    </td>
                    <td>
                        {{ $packagepurchase->applicationpackage->title }}
                    </td>
                    <td>
                        {{ $packagepurchase->price_incl_discount }} €
                    </td>
                    <td>
                        <a href="{{ route('packagepurchases.detail', $packagepurchase->id) }}"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
                    </td>
                    <td>
                        <a href="{{ route('packagepurchases.edit', $packagepurchase->id) }}"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="{{ route('packagepurchases.confirm', $packagepurchase->id) }}"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $packagepurchases->links() }}

    <script>
        function search() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("packagepurchaseTable");
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