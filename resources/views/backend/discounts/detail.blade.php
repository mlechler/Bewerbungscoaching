@extends('layouts.backend')

@section('title', 'Details of '.$discount->title)

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Title</h4>
            </td>
            <td>
                <h4>{{ $discount->title }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Service</h4>
            </td>
            <td>
                <h4>{{ $discount->service }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Amount</h4>
            </td>
            <td>
                <h4>{{ $discount->amount }} {{ $discount->getAmountType()}}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Validity</h4>
            </td>
            <td>
                <h4>{{ $discount->getValidity() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Code</h4>
            </td>
            <td>
                <h4>{{ $discount->code }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Expired</h4>
            </td>
            <td>
                <h4><span class="glyphicon glyphicon-{{ $discount->expired ? 'ok' : 'remove' }}"></span></h4>
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('discounts.index') }}" class="btn btn-danger">Back</a>
@endsection