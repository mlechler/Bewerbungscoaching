@extends('layouts.backend')

@section('title', 'Members')

@section('content')
    <a href="{{ route('members.create') }}" class="btn btn-primary">Create New Member</a>
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
        @if($members->isEmpty())
            <tr>
                <td colspan="5" align="center">There are no members.</td>
            </tr>
        @else
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
                        <a href="/backend/members/<?php echo $member->id ?>/edit"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/backend/members/<?php echo $member->id ?>/confirm"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $members->links() }}
@endsection