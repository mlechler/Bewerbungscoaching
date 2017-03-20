@extends('layouts.backend')

@section('title', 'Contact Requests')

@section('content')
    <div class="form-group row">
        <div class="col-md-9"></div>
        {{ Form::open([
            'method' => 'post',
            'route' => 'contact.deleteAllFinishedRequests'
            ]) }}
        <div class="col-md-3" align="right">
            {{ Form::submit('Delete Finished Contact Requests', ['class' => 'btn btn-danger']) }}
        </div>
        {{ Form::close() }}
    </div>

    {{ Form::open() }}
    <div class="form-group has-feedback has-feedback-left">
        <br>
        {{ Form::text('searchInput', null, ['class' => 'form-control', 'id' => 'searchInput', 'onkeyup' => 'search()', 'placeholder' => 'Search for Name or Email']) }}
        <i class="form-control-feedback glyphicon glyphicon-search"></i>
    </div>
    {{ Form::close() }}
    <table class="table table-hover" id="contactRequestTable">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Category</th>
            <th>Details</th>
            <th>Processing</th>
            <th>Finished</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($contactrequests->isEmpty())
            <tr>
                <td colspan="7" align="center">There are no contact requests.</td>
            </tr>
        @else
            @foreach($contactrequests as $request)
                <tr class="{{ $request->highlight() }}">
                    <td>
                        {{ $request->name }}
                    </td>
                    <td>
                        {{ $request->email }}
                    </td>
                    <td>
                        {{ $request->category }}
                    </td>
                    <td>
                        <a href="{{ route('contact.detail', $request->id) }}"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
                    </td>
                    <td>
                        @if($request->category != 'feedback')
                            <a href="{{ route('contact.processRequest', $request->id) }}"><span
                                        class="glyphicon glyphicon-repeat"></span></a>
                        @endif
                    </td>
                    <td>
                        @if($request->category != 'feedback')
                            <a href="{{ route('contact.finishedRequest', $request->id) }}"><span
                                        class="glyphicon glyphicon-ok"></span></a>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('contact.confirm', $request->id) }}"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $contactrequests->links() }}

    <script>
        function search() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("contactRequestTable");
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