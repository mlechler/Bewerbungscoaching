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
                <h4>Color</h4>
            </td>
            <td>
                <h4 style="color: {{ $employee->color }}" title="{{ $employee->color }}">█</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Contribution Individual Coachings</h4>
            </td>
            <td>
                <h4>{{ $employee->contribution }} €</h4>
                @if($backendUser->isAdmin())
                    <a href="{{ route('employees.reset', $employee->id) }}"
                       class="btn btn-default">Reset</a>
                @endif
            </td>
        </tr>
        <tr>
            <td>
                <h4>Files</h4>
            </td>
            <td>
                @foreach($employee->employeeFiles as $file)
                    <a href="{{ $file->download }}" target="_blank">{{ $file->name }}</a>
                @endforeach
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-success">Change Data</a>
    @if($backendUser->isAdmin())
        <a href="{{ route('employees.index') }}" class="btn btn-danger">Back</a>
    @else
        <a href="{{ route('backend.dashboard') }}" class="btn btn-danger">Back</a>
    @endif
@endsection