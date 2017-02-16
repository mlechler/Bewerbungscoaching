@extends('layouts.frontend')

@section('title', 'Seminars')

@section('content')
    <div id="seminars">
        @foreach($appointments as $appointment)
            <div class="panel-group">
                <div class="panel panel-default panel-{{ $appointment->highlightPanel() }}">
                    <div class="panel-heading">
                        <h4 class="panel-title row">
                            <a data-toggle="collapse"
                               href="#collapse{{ $appointment->id }}">
                                <div class="col-md-6">{{ $appointment->seminar->title }}</div>
                                <div class="col-md-3">{{ $appointment->formatDate() }}
                                    , {{ $appointment->formatTime() }}</div>
                                <div class="col-md-3" align="right">{{ $appointment->members->count() }}
                                    / {{ $appointment->seminar->maxMembers }} Participants
                                </div>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse{{ $appointment->id }}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <strong>Description</strong><br>
                            {!! $appointment->seminar->descriptionHtml() !!}
                            <strong>Services</strong><br>
                            {{ $appointment->seminar->services }}<br><br>
                            <strong>Employee</strong><br>
                            {{ $appointment->employee->getName() }}<br><br>
                            <strong>Address</strong><br>
                            {{ $appointment->address->zip }}, {{ $appointment->address->city }}<br>
                            {{ $appointment->address->street }} {{ $appointment->address->housenumber }}<br><br>
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <a href="https://www.google.de/maps/place/{{ $appointment->address->latitude}},{{ $appointment->address->longitude}}">
                                        <img
                                                src="https://maps.googleapis.com/maps/api/staticmap?maptype=roadmap&center={{ $appointment->address->latitude}},{{ $appointment->address->longitude}}&markers=color:red%7C{{ $appointment->address->latitude}},{{ $appointment->address->longitude}}&zoom=15&size=640x400&key=AIzaSyDqNRudzEWZbavF28VmoCdaKnPNCElt6UQ"
                                    style="width: 640px; height: 400px;"></a>
                                    {{--@include('frontend.map', ['address' => $appointment->address])--}}
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <br>
                            <strong>Price</strong><br>
                            {{ $appointment->seminar->price }} €<br><br>
                            <button class="btn btn-success">Make a Booking</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        var $seminars = $('#seminars');
        $seminars.on('show.bs.collapse', '.collapse', function () {
            $seminars.find('.collapse.in').collapse('hide');
        });
    </script>
@endsection