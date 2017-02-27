@extends('layouts.frontend')

@section('title', 'My Information')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h3><strong>Personal Information</strong></h3>
            <table class="table">
                <tr>
                    <td>
                        <strong>Name</strong>
                    </td>
                    <td>
                        {{ $loggedInUser->firstname }} {{ $loggedInUser->lastname }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Birthday</strong>
                    </td>
                    <td>
                        {{ date_format($loggedInUser->birthday,'d.m.Y') }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Phone</strong>
                    </td>
                    <td>
                        {{ $loggedInUser->phone }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Mobile</strong>
                    </td>
                    <td>
                        {{ $loggedInUser->mobile }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Email</strong>
                    </td>
                    <td>
                        {{ $loggedInUser->email }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Address</strong>
                    </td>
                    <td>
                        {{ $loggedInUser->address->zip }} {{ $loggedInUser->address->city }}
                        , {{ $loggedInUser->address->street }} {{ $loggedInUser->address->housenumber }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Job</strong>
                    </td>
                    <td>
                        {{ $loggedInUser->job }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Employer</strong>
                    </td>
                    <td>
                        {{ $loggedInUser->employer }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>University</strong>
                    </td>
                    <td>
                        {{ $loggedInUser->university }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Course Of Studies</strong>
                    </td>
                    <td>
                        {{ $loggedInUser->courseofstudies }}
                    </td>
                </tr>
            </table>
            <a href="{{ route('frontend.myinformation.edit') }}" class="btn btn-default">Change Personal Information</a>
            <a href="{{ route('member.password.update') }}" class="btn btn-default">Change Password</a>
            <a href="{{ route('frontend.myinformation.files') }}" class="btn btn-default">Manage Files</a>
        </div>
        <div class="col-md-6">
            <h3><strong>Events</strong></h3>
            <table class="table">
                <tr>
                    <td>
                        <h4><strong>Seminars</strong></h4>
                        @if($seminars)
                            @foreach($seminars as $seminar)
                                <strong>Title: </strong>{{ $seminar->appointment->seminar->title }} <br>
                                <strong>Date: </strong>{{ $seminar->appointment->formatDate() }} <br>
                                <strong>Time: </strong>{{ $seminar->appointment->formatTime() }} <br>
                                <strong>Address: </strong>{{ $seminar->appointment->address->zip }} {{ $seminar->appointment->address->city }}
                                , {{ $seminar->appointment->address->street }} {{ $seminar->appointment->address->housenumber }}
                                <br>
                                <strong>Employee: </strong>{{ $seminar->appointment->employee->firstname }} {{ $seminar->appointment->employee->lastname }}
                                <br><br>
                                @foreach($seminar->appointment->seminar->seminarFiles as $file)
                                    <a href="{{ $file->download }}" target="_blank">{{ $file->name }}</a><br>
                                @endforeach
                            @endforeach
                        @else
                            There are no Seminars.
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4><strong>Individual Coachings</strong></h4>
                        @if($coachings)
                            @foreach($coachings as $coaching)
                                <strong>Services: </strong>{{ $coaching->services }} <br>
                                <strong>Date: </strong>{{ $coaching->formatDate() }} <br>
                                <strong>Time: </strong>{{ $coaching->formatTime() }} @if($coaching->trial)
                                    (Trial) @endif <br>
                                <strong>Address: </strong>{{ $coaching->address->zip }} {{ $coaching->address->city }}
                                , {{ $coaching->address->street }} {{ $coaching->address->housenumber }} <br>
                                <strong>Employee: </strong>{{ $coaching->employee->firstname }} {{ $coaching->employee->lastname }}
                                <br><br>
                            @endforeach
                        @else
                            There are no Individual Coachings.
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h3><strong>Application Documents</strong></h3>
            <table class="table">
                <tr>
                    <td>
                        <h4><strong>Application Layouts</strong></h4>
                        @if($applicationlayouts)
                            @foreach($applicationlayouts as $layout)
                                <strong>Title: </strong>{{ $layout->applicationlayout->title }} <br>
                                <strong>Data</strong>
                                <br><br>
                            @endforeach
                        @else
                            There are no Application Layouts.
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4><strong>Application Packages</strong></h4>
                        @if($applicationpackages)
                            @foreach($applicationpackages as $package)
                                <strong>Title: </strong>{{ $package->applicationpackage->title }} <br>
                                <strong>Data</strong>
                                <br><br>
                            @endforeach
                        @else
                            There are no Application Packages.
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <h3><strong>Former Events</strong></h3>
            <table class="table">
                <tr>
                    <td>
                        <h4><strong>Seminars</strong></h4>
                        @if($formerseminars)
                            @foreach($formerseminars as $formerseminar)
                                <strong>Title: </strong>{{ $formerseminar->appointment->seminar->title }} <br>
                                <strong>Date: </strong>{{ $formerseminar->appointment->formatDate() }} <br>
                                <strong>Time: </strong>{{ $formerseminar->appointment->formatTime() }} <br>
                                <strong>Address: </strong>{{ $formerseminar->appointment->address->zip }} {{ $formerseminar->appointment->address->city }}
                                , {{ $formerseminar->appointment->address->street }} {{ $formerseminar->appointment->address->housenumber }}
                                <br>
                                <strong>Employee: </strong>{{ $formerseminar->appointment->employee->firstname }} {{ $formerseminar->appointment->employee->lastname }}
                                <br><br>
                            @endforeach
                        @else
                            There are no former Seminars.
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4><strong>Individual Coachings</strong></h4>
                        @if($formercoachings)
                            @foreach($formercoachings as $formercoaching)
                                <strong>Services: </strong>{{ $formercoaching->services }} <br>
                                <strong>Date: </strong>{{ $formercoaching->formatDate() }} <br>
                                <strong>Time: </strong>{{ $formercoaching->formatTime() }} @if($formercoaching->trial)
                                    (Trial) @endif <br>
                                <strong>Address: </strong>{{ $formercoaching->address->zip }} {{ $formercoaching->address->city }}
                                , {{ $formercoaching->address->street }} {{ $formercoaching->address->housenumber }}
                                <br>
                                <strong>Employee: </strong>{{ $formercoaching->employee->firstname }} {{ $formercoaching->employee->lastname }}
                                <br><br>
                            @endforeach
                        @else
                            There are no former Individual Coachings.
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection