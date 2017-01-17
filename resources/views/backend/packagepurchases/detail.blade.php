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
                <h4>{{ $packagepurchase->member->getName() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Package</h4>
            </td>
            <td>
                <h4>{{ $packagepurchase->applicationpackage->title }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Price</h4>
            </td>
            <td>
                <h4>{{ $packagepurchase->price_incl_discount }} €</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Paid</h4>
            </td>
            <td>
                <h4><span class="glyphicon glyphicon-{{ $packagepurchase->paid ? 'ok' : 'remove' }}"></span></h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>File</h4>
            </td>
            <td>
                @if($packagepurchase->path)
                    <div class="row">
                        <div class="col-md-3">
                            {{ $packagepurchase->getFilename() }}
                        </div>
                        <div class="col-md-1">
                            <a href="/backend/packagepurchases/files/<?php echo $packagepurchase->id ?>/delete"><span
                                        class="glyphicon glyphicon-remove"></span></a></div>
                    </div>
                @endif
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('packagepurchases.index') }}" class="btn btn-danger">Back</a>
@endsection