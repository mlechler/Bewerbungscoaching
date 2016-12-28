@extends('layouts.backend')

@section('title', 'Members')

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
        @foreach($members as $member)
            <tr>
                <td>
                    {{ $member->lastname }}
                </td>
                <td>
                    {{ $member->firstname }}
                </td>
                <td>
                    {{ $member->email }}
                </td>
                <td>
                    <a href="/admin/members/<?php echo $member->id ?>/edit"><span class="glyphicon glyphicon-edit"></span></a>
                </td>
                <td>
                    <a href="/admin/members/<?php echo $member->id ?>/confirm"><span class="glyphicon glyphicon-remove"></span></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection