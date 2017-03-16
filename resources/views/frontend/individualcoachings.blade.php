@extends('layouts.frontend')

@section('title', 'Individual Coachings')

@section('content')
    <div class="row">
        @if($calendar)
            <div class="col-md-8">
                {!! $calendar->calendar() !!}
                {!! $calendar->script() !!}
            </div>
            <div class="col-md-4">
                Employeelist
            </div>
        @else
            <div class="col-md-12" align="center">
                Currently is no Individual Coaching available.
            </div>
        @endif
    </div>
@endsection