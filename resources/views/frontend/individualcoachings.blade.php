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
                <br><br>
                <h5><strong>List of Employees</strong></h5>
                @foreach($employees as $employee)
                    <div class="row">
                        <div class="col-md-6">
                            {{ $employee->getName() }} </div>
                        <div class="col-md-6">
                            <span style="color: {{ $employee->color }}" title="{{ $employee->color }}">█</span>
                        </div>
                        <br>
                    </div>
                @endforeach
            </div>
        @else
            <div class="col-md-12" align="center">
                Currently are no Individual Coachings available.
            </div>
        @endif
    </div>
@endsection