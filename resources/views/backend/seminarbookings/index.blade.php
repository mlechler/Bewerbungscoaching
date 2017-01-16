@extends('layouts.backend')

@section('title', 'Bookings')

@section('content')
    <a href="{{ route('seminarbookings.create') }}" class="btn btn-primary">Create New Booking</a>
    {{ Form::open() }}
    <div class="form-group has-feedback has-feedback-left">
        <br>
        {{ Form::text('searchInput', null, ['class' => 'form-control', 'id' => 'searchInput', 'onkeyup' => 'search()', 'placeholder' => 'Search for Member or Appointment']) }}
        <i class="form-control-feedback glyphicon glyphicon-search"></i>
    </div>
    {{ Form::close() }}
    <table class="table table-hover" id="bookingTable">
        <thead>
        <tr>
            <th>Member</th>
            <th>Appointment</th>
            <th>Price</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($seminarbookings->isEmpty())
            <tr>
                <td colspan="5" align="center">There are no appointments.</td>
            </tr>
        @else
            @foreach($seminarbookings as $booking)
                <tr>
                    <td>
                        {{ $booking->member->getName() }}
                    </td>
                    <td>
                        {{ $booking->getAppointment() }}
                    </td>
                    <td>
                        {{ $booking->price_incl_discount }} €
                    </td>
                    <td>
                        <a href="/backend/seminarbookings/<?php echo $booking->id ?>/detail"><span
                                    class="glyphicon glyphicon-info-sign"></span>
                    </td>
                    <td>
                        <a href="/backend/seminarbookings/<?php echo $booking->id ?>/edit"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/backend/seminarbookings/<?php echo $booking->id ?>/confirm"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $seminarbookings->links() }}

    <script>
        function search() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("bookingTable");
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