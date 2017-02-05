@extends('layouts.backend')

@section('title', 'Appointments')

@section('content')
    <a href="{{ route('seminarappointments.create') }}" class="btn btn-primary">Create New Appointment</a>
    {{ Form::open() }}
    <div class="form-group has-feedback has-feedback-left">
        <br>
        {{ Form::text('searchInput', null, ['class' => 'form-control', 'id' => 'searchInput', 'onkeyup' => 'search()', 'placeholder' => 'Search for Seminar or Employee']) }}
        <i class="form-control-feedback glyphicon glyphicon-search"></i>
    </div>
    {{ Form::close() }}
    <table class="table table-hover" id="appointmentTable">
        <thead>
        <tr>
            <th>Seminar</th>
            <th>Employee</th>
            <th>Date</th>
            <th>Time</th>
            <th>Participants</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($seminarappointments->isEmpty())
            <tr>
                <td colspan="7" align="center">There are no appointments.</td>
            </tr>
        @else
            @foreach($seminarappointments as $appointment)
                <tr class="{{ $appointment->overHighlight() }}">
                    <td>
                        {{ $appointment->seminar->title }}
                    </td>
                    <td>
                        {{ $appointment->employee->getName() }}
                    </td>
                    <td>
                        {{ $appointment->formatDate() }}
                    </td>
                    <td>
                        {{ $appointment->formatTime() }}
                    </td>
                    <td>
                        <a href="{{ route('seminarappointments.detail', $appointment->id) }}"><span
                                    class="glyphicon glyphicon-info-sign"></span>  {{ $appointment->members->count()}}/{{ $appointment->seminar->maxMembers }}</a>
                    </td>
                    <td>
                        <a href="{{ route('seminarappointments.edit', $appointment->id) }}"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="{{ route('seminarappointments.confirm', $appointment->id) }}"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $seminarappointments->links() }}

    <script>
        function search() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("appointmentTable");
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