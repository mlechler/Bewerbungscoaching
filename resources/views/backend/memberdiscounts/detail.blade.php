@extends('layouts.backend')

@section('title', 'Details of VALUE')

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Member</h4>
            </td>
            <td>
                <h4>{{ $memberdiscount->member->getName() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Discount</h4>
            </td>
            <td>
                <h4>{{ $memberdiscount->discount->title }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Validity</h4>
            </td>
            <td>
                <h4>{{ $memberdiscount->getValidity() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Code</h4>
            </td>
            <td>
                <h4>{{ $memberdiscount->code }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Expired</h4>
            </td>
            <td>
                <h4><span class="glyphicon glyphicon-{{ $memberdiscount->expired ? 'ok' : 'remove' }}"></span></h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Cashed In</h4>
            </td>
            <td>
                <h4><span class="glyphicon glyphicon-{{ $memberdiscount->cashedin ? 'ok' : 'remove' }}"></span></h4>
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('memberdiscounts.index') }}" class="btn btn-danger">Back</a>
@endsection