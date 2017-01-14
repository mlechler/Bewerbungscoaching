@extends('layouts.backend')

@section('title', 'Memberdiscounts')

@section('content')
    <a href="{{ route('memberdiscounts.create') }}" class="btn btn-primary">Create New Memberdiscount</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Member</th>
            <th>Discount</th>
            <th>Validity</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($memberdiscounts->isEmpty())
            <tr>
                <td colspan="6" align="center">There are no memberdiscounts.</td>
            </tr>
        @else
            @foreach($memberdiscounts as $memberdiscount)
                <tr class="{{ $memberdiscount->expirationHighlight() }}">
                    <td>
                        {{ $memberdiscount->member->getName() }}
                    </td>
                    <td>
                        {{ $memberdiscount->discount->title }}
                    </td>
                    <td>
                        {{ $memberdiscount->getValidity() }}
                    </td>
                    <td>
                        <a href="/backend/memberdiscounts/<?php echo $memberdiscount->id ?>/detail"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
                    </td>
                    <td>
                        <a href="/backend/memberdiscounts/<?php echo $memberdiscount->id ?>/edit"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="/backend/memberdiscounts/<?php echo $memberdiscount->id ?>/confirm"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $memberdiscounts->links() }}
@endsection