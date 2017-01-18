@extends('layouts.backend')

@section('title', 'Discounts')

@section('content')
    <a href="{{ route('discounts.create') }}" class="btn btn-primary">Create New Discount</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>Service</th>
            <th>Amount</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($discounts->isEmpty())
            <tr>
                <td colspan="6" align="center">There are no discounts.</td>
            </tr>
        @else
            @foreach($discounts as $discount)
                <tr>
                    <td>
                        {{ $discount->title }}
                    </td>
                    <td>
                        {{ $discount->service }}
                    </td>
                    <td>
                        {{ $discount->amount }} {{ $discount->getAmountType()}}
                    </td>
                    <td>
                        <a href="{{ route('discounts.detail', $discount->id) }}"><span
                                    class="glyphicon glyphicon-info-sign"></span></a>
                    </td>
                    <td>
                        <a href="{{ route('discounts.edit', $discount->id) }}"><span
                                    class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    <td>
                        <a href="{{ route('discounts.confirm', $discount->id) }}"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    {{ $discounts->links() }}
@endsection