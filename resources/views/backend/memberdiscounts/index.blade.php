@extends('layouts.backend')

@section('title', 'Memberdiscounts')

@section('content')
    <a href="{{ route('memberdiscounts.create') }}" class="btn btn-primary">Create New Memberdiscount</a>
    {{ Form::open() }}
    <div class="form-group has-feedback has-feedback-left">
        <br>
        {{ Form::text('searchInput', null, ['class' => 'form-control', 'id' => 'searchInput', 'onkeyup' => 'search()', 'placeholder' => 'Search for Member or Discount']) }}
        <i class="form-control-feedback glyphicon glyphicon-search"></i>
    </div>
    {{ Form::close() }}
    <table class="table table-hover" id="memberdiscountTable">
        <thead>
        <tr>
            <th>Member</th>
            <th>Discount</th>
            <th>Validity</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($memberdiscounts->isEmpty())
            <tr>
                <td colspan="6" align="center">There are no memberdiscounts.</td>
            </tr>
        @else
            @foreach($memberdiscounts as $memberdiscount)
                <tr class="{{ $memberdiscount->expirationHighlight() }}">
                    <td>
                        {{ $memberdiscount->member->getName() }}
                    </td>
                    <td>
                        {{ $memberdiscount->discount->title }}
                    </td>
                    <td>
                        {{ $memberdiscount->getValidity() }}
                    </td>
                    <td>
                        <a href="{{ route('memberdiscounts.detail', $memberdiscount->id) }}"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
                    </td>
                    <td>
                        <a href="{{ route('memberdiscounts.edit', $memberdiscount->id) }}"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="{{ route('memberdiscounts.confirm', $memberdiscount->id) }}"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $memberdiscounts->links() }}

    <script>
        function search() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("memberdiscountTable");
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