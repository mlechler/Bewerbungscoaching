@extends('layouts.backend')

@section('title', 'Employees')

@section('content')
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Lastname</th>
                <th>Firstname</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>
                        {{ $employee->lastname }}
                    </td>
                    <td>
                        {{ $employee->firstname }}
                    </td>
                    <td>
                        {{ $employee->email }}
                    </td>
                    <td>
                        <a href="/admin/employees/<?php echo $employee->id ?>/edit"><span class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/admin/employees/<?php echo $employee->id ?>/confirm"><span class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection