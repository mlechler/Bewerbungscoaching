@extends('layouts.backend')

@section('title', 'Details of '.$employee->getName())

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Lastname</h4>
            </td>
            <td>
                <h4>{{ $employee->lastname }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Firstname</h4>
            </td>
            <td>
                <h4>{{ $employee->firstname }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Birthday</h4>
            </td>
            <td>
                <h4>{{ $employee->formatBirthday() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Phone</h4>
            </td>
            <td>
                <h4>{{ $employee->phone }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Mobile</h4>
            </td>
            <td>
                <h4>{{ $employee->mobile }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Email</h4>
            </td>
            <td>
                <h4>{{ $employee->email }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Address</h4>
            </td>
            <td>
                <h4>{{ $employee->formatAddress() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Role</h4>
            </td>
            <td>
                <h4>{{ $employee->role->display_name }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Files</h4>
            </td>
            <td>
                @foreach($employee->employeeFiles as $file)
                    {{ $file->name }}
                @endforeach
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('employees.index') }}" class="btn btn-danger">Back</a>
@endsection