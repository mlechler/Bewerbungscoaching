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
                                <div class="col-md-2"></div>
                                <div class="col-md-8" align="center">
                                    <a target="_blank"
                                       href="https://www.google.de/maps/place/{{ $appointment->address->latitude}},{{ $appointment->address->longitude}}">
                                        <img
                                                src="https://maps.googleapis.com/maps/api/staticmap?maptype=roadmap&center={{ $appointment->address->latitude}},{{ $appointment->address->longitude}}&markers=color:red%7C{{ $appointment->address->latitude}},{{ $appointment->address->longitude}}&zoom=15&size=640x400&key=AIzaSyDqNRudzEWZbavF28VmoCdaKnPNCElt6UQ"
                                                style="width: 640px; height: 400px;"></a>
                                    <p class="help-block">Click on the map to see it in fullscreen.</p>
                                    {{--@include('frontend.map', ['address' => $appointment->address])--}}
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <br>
                            <strong>Price</strong><br>
                            {{ $appointment->seminar->price }} €<br><br>
                            @if($loggedInUser && $appointment->members->count() < $appointment->seminar->maxMembers)
                                <button class="btn btn-success" data-toggle="modal"
                                        data-target="#modal{{ $appointment->id }}">Make a Booking
                                </button>
                            @else
                                <button class="btn btn-success" disabled>Make a Booking</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div id="modal{{ $appointment->id }}" class="modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <p class="modal-title">Your Booking</p>
                        </div>
                        {{ Form::open([
                        'method' =>'post',
                        'route' => ['frontend.seminars.makeBooking', $appointment->id]
                        ]) }}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Payment Method</strong>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('PayPal') }}
                                        {{ Form::radio('type','paypal') }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('transfer') }}
                                        {{ Form::radio('type','transfer') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-md-offset-4">
                                    {{ Form::text('code', null, ['class' => 'form-control', 'placeholder' => 'Discount']) }}</td>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Check your Article</strong>
                                </div>
                                <div class="col-md-4">
                                    <strong>{{ $appointment->seminar->title }}</strong><br>
                                    {{ $appointment->seminar->services }} <br>
                                    {{ $appointment->formatDate() }} <br>
                                    {{ $appointment->formatTime() }} <br>
                                </div>
                                <div class="col-md-4">
                                    <br>
                                    {{ $appointment->address->zip }} {{ $appointment->address->city }} <br>
                                    {{ $appointment->address->street }} {{ $appointment->address->housenumber }} <br>
                                    <br>
                                    <div align="right"><strong>{{ $appointment->seminar->price }} €</strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            {{ Form::submit('Make a Booking', ['class' => 'btn btn-success']) }}
                        </div>
                        {{ Form::close() }}
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