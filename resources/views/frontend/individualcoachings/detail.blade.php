@extends('layouts.frontend')

@section('title', 'Individual Coaching Overview')

@section('content')
    {{ Form::open([
    'method' => 'post',
    'route' => ['frontend.individualcoachings.makeBooking', $freetime->id]
    ]) }}

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('employee') }} <br>
            {{ $freetime->employee->getName() }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('hourly_rate') }} <br>
            {{ $freetime->hourlyrate }} €
            {{ Form::hidden('hourlyrate', $freetime->hourlyrate, ['id' => 'hourlyrate']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('services') }} <br>
            {{ $freetime->services }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('address') }} <br>
            {{ $freetime->formatAddress() }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('date') }} <br>
            {{ $freetime->formatDate() }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('start_time') }}
            {{ Form::text('starttime', $freetime->starttime, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('end_time') }}
            {{ Form::text('endtime', $freetime->endtime, ['class' => 'form-control']) }}
        </div>
    </div>

    <button type="button" class="btn btn-success" data-toggle="modal"
            data-target="#modal{{ $freetime->id }}">Make a Booking
    </button>
    <a href="{{ route('frontend.individualcoachings.index') }}" class="btn btn-danger">Back</a>

    <div id="modal{{ $freetime->id }}" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <p class="modal-title">Your Booking</p>
                </div>
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
                            <strong>Individual Coaching</strong><br>
                            {{ $freetime->employee->getName() }} <br>
                            {{ $freetime->formatDate() }} <br>
                            Duration: <span id="duration"></span> <br>
                            Hourly rate: {{ $freetime->hourlyrate }} €
                        </div>
                        <div class="col-md-4" align="right">
                            <br>
                            {{ $freetime->address->zip }} {{ $freetime->address->city }} <br>
                            {{ $freetime->address->street }} {{ $freetime->address->housenumber }} <br>
                            <br>
                            <br>
                            <strong><span id="price"></span></strong>
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

    <script>
        $('input[name=starttime]').datetimepicker({
            allowInputToggle: true,
            format: 'HH:mm',
            showClear: true,
            stepping: 30,
            minDate: moment(document.getElementsByName('starttime')[0].value, 'HH:mm'),
//            maxDate: moment(document.getElementsByName('endtime')[0].value, 'HH:mm')
        });
        $('input[name=endtime]').datetimepicker({
            allowInputToggle: true,
            format: 'HH:mm',
            showClear: true,
            stepping: 30,
//            minDate: moment(document.getElementsByName('starttime')[0].value, 'HH:mm'),
            maxDate: moment(document.getElementsByName('endtime')[0].value, 'HH:mm')
        });
        $('.modal').on('show.bs.modal', function () {
            var starttime = document.getElementsByName('starttime')[0].value.split(':');
            var endtime = document.getElementsByName('endtime')[0].value.split(':');
            var hours = endtime[0] - starttime[0];
            var minutes = endtime[1] - starttime[1];
            if (minutes < 0) {
                hours = hours - 1;
                minutes = 60 + minutes;
            }
            if (hours < 10) {
                hours = '0' + hours;
            }
            if (minutes < 10) {
                minutes = '0' + minutes;
            }
            var hourlyrate = document.getElementById('hourlyrate').value;
            var price = hourlyrate * hours + hourlyrate * minutes / 60;

            document.getElementById('duration').textContent = hours + ':' + minutes;
            document.getElementById('price').textContent = price + ' €';
        });
    </script>
@endsection