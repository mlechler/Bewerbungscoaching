@extends('layouts.backend')

@section('title', 'Members')

@section('content')

    <div class="form-group row ">
        <div class="col-md-8">
            <a href="{{ route('members.create') }}" class="btn btn-primary">Create New Member</a>
        </div>
        {{ Form::open([
        'method' => 'post',
        'route' => 'members.deleteAllFiles'
        ]) }}
        <div class="col-md-2 deleteFiles">
            {{ Form::select('timerange', [
                '' => '',
                'one' => 'one Month',
                'three' => 'three Months',
                'six' => 'six Months'
            ], null, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-2 deleteFiles">
            {{ Form::submit('Delete Files, older than', ['class' => 'btn btn-danger']) }}
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
    <table class="table table-hover" id="memberTable">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>All Files Checked?</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($members->isEmpty())
            <tr>
                <td colspan="6" align="center">There are no members.</td>
            </tr>
        @else
            @foreach($members as $member)
                <tr>
                    <td>
                        {{ $member->getName() }}
                    </td>
                    <td>
                        {{ $member->email }}
                    </td>
                    <td>
                        @if($member->memberFiles->isEmpty())
                            No Files Uploaded
                        @else
                            <span class="glyphicon glyphicon-certificate {{ $member->getUncheckedFiles() }}"></span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('members.detail', $member->id) }}"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
                    </td>
                    <td>
                        <a href="{{ route('members.edit', $member->id) }}"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="{{ route('members.confirm', $member->id) }}"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $members->links() }}

    <script>
        function search() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("memberTable");
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