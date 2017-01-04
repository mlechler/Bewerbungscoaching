@extends('layouts.backend')

@section('title', 'Details of '.$member->getName())

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Lastname</h4>
            </td>
            <td>
                <h4>{{ $member->lastname }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Firstname</h4>
            </td>
            <td>
                <h4>{{ $member->firstname }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Birthday</h4>
            </td>
            <td>
                <h4>{{ $member->formatBirthday() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Phone</h4>
            </td>
            <td>
                <h4>{{ $member->phone }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Mobile</h4>
            </td>
            <td>
                <h4>{{ $member->mobile }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Email</h4>
            </td>
            <td>
                <h4>{{ $member->email }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Adress</h4>
            </td>
            <td>
                <h4>{{ $member->formatAdress($adress) }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Job</h4>
            </td>
            <td>
                <h4>{{ $member->job }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Employer</h4>
            </td>
            <td>
                <h4>{{ $member->employer }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>University</h4>
            </td>
            <td>
                <h4>{{ $member->university }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Course Of Studies</h4>
            </td>
            <td>
                <h4>{{ $member->courseofstudies }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Role</h4>
            </td>
            <td>
                <h4>{{ $roles[$member->role_id] }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Files</h4>
            </td>
            <td>
                @foreach($files as $file)
                    {{ $file }}
                @endforeach
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('members.index') }}" class="btn btn-danger">Back</a>
@endsection