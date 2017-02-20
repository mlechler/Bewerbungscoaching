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
        </div>
        <div class="col-md-6">
            <h3><strong>Events</strong></h3>
            <table class="table">
                <tr>
                    <td>
                        <h4><strong>Seminars</strong></h4>
                        test <br>
                        test <br>
                        test <br>
                        test <br>
                        test <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4><strong>Individual Coachings</strong></h4>
                        test <br>
                        test <br>
                        test <br>
                        test <br>
                        test <br>
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
                        test <br>
                        test <br>
                        test <br>
                        test <br>
                        test <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4><strong>Application Packages</strong></h4>
                        test <br>
                        test <br>
                        test <br>
                        test <br>
                        test <br>
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
                        test <br>
                        test <br>
                        test <br>
                        test <br>
                        test <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4><strong>Individual Coachings</strong></h4>
                        test <br>
                        test <br>
                        test <br>
                        test <br>
                        test <br>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection