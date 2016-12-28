@extends('layouts.backend')

@section('title', 'Seminars')

@section('heading', 'Seminars')

@section('content')
    <a href="#" class="btn btn-primary">Create new Seminar</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Maximum Participants</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($seminars->isEmpty())
            <tr>
                <td colspan="5" align="center">There are no seminars.</td>
            </tr>
        @else
            @foreach($seminars as $seminar)
                <tr>
                    <td>
                        {{ $seminar->title }}
                    </td>
                    <td>
                        {{ $seminar->description }}
                    </td>
                    <td>
                        {{ $seminar->maxMembers }}
                    </td>
                    <td>
                        <a href="/admin/seminars/<?php echo $seminar->id ?>/edit"><span class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/admin/seminars/<?php echo $seminar->id ?>/confirm"><span class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $seminars->links() }}
@endsection