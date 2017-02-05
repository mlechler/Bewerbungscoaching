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
                <h4>{{ $layoutpurchase->member->getName() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Layout</h4>
            </td>
            <td>
                <h4>{{ $layoutpurchase->applicationlayout->title }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Price</h4>
            </td>
            <td>
                <h4>{{ $layoutpurchase->price_incl_discount }} €</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Paid</h4>
            </td>
            <td>
                <h4><span class="glyphicon glyphicon-{{ $layoutpurchase->paid ? 'ok' : 'remove' }}"></span></h4>
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('layoutpurchases.index') }}" class="btn btn-danger">Back</a>
@endsection