@extends('layouts.backend')

@section('title', 'Details of '.$package->title)

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Title</h4>
            </td>
            <td>
                <h4>{{ $package->title }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Price</h4>
            </td>
            <td>
                <h4>{{ $package->price }} €</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Description</h4>
            </td>
            <td>
                <h4>{!! $package->descriptionHtml() !!}</h4>
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('applicationpackages.index') }}" class="btn btn-danger">Back</a>
@endsection