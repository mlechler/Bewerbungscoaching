@extends('layouts.backend')

@section('title', 'Individual Coachings')

@section('content')
    <a href="{{ route('individualcoachings.create') }}" class="btn btn-primary">Create New Coaching</a>
    {{ Form::open() }}
    <div class="form-group has-feedback has-feedback-left">
        <br>
        {{ Form::text('searchInput', null, ['class' => 'form-control', 'id' => 'searchInput', 'onkeyup' => 'search()', 'placeholder' => 'Search for Employee or Member']) }}
        <i class="form-control-feedback glyphicon glyphicon-search"></i>
    </div>
    {{ Form::close() }}
    <table class="table table-hover" id="coachingTable">
        <thead>
        <tr>
            <th>Employee</th>
            <th>Member</th>
            <th>Date</th>
            <th>Time</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($coachings->isEmpty())
            <tr>
                <td colspan="7" align="center">There are no coachings.</td>
            </tr>
        @else
            @foreach($coachings as $coaching)
                <tr class="{{ $coaching->trialHighlight() }}">
                    <td>
                        {{ $coaching->employee->getName() }}
                    </td>
                    <td>
                        {{ $coaching->member->getName() }}
                    </td>
                    <td>
                        {{ $coaching->formatDate() }}
                    </td>
                    <td>
                        {{ $coaching->formatTime() }}
                    </td>
                    <td>
                        <a href="/backend/individualcoachings/<?php echo $coaching->id ?>/detail"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
                    </td>
                    <td>
                        <a href="/backend/individualcoachings/<?php echo $coaching->id ?>/edit"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/backend/individualcoachings/<?php echo $coaching->id ?>/confirm"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $coachings->links() }}

    <script>
        function search() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("coachingTable");
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