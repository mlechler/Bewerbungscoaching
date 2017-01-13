@extends('layouts.backend')

@section('title', 'Employees')

@section('content')
    <a href="{{ route('employees.create') }}" class="btn btn-primary">Create New Employee</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach($employees as $employee)
            <tr>
                <td>
                    {{ $employee->getName() }}
                </td>
                <td>
                    {{ $employee->email }}
                </td>
                <td>
                    {{ $employee->role->display_name }}
                </td>
                <td>
                    <a href="/backend/employees/<?php echo $employee->id ?>/detail"><span
                                class="glyphicon glyphicon-info-sign"></span></a>
                </td>
                <td>
                    <a href="/backend/employees/<?php echo $employee->id ?>/edit"><span
                                class="glyphicon glyphicon-edit"></span></a>
                </td>
                <td>
                    <a href="/backend/employees/<?php echo $employee->id ?>/confirm"><span
                                class="glyphicon glyphicon-remove"></span></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $employees->links() }}
@endsection