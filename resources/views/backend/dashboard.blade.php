@extends('layouts.backend')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-6">
            @widget('recentPosts')
        </div>
        <div class="col-md-6">
            @widget('recentEmployees')
            @widget('recentMembers')
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            @widget('paypalTransactions')
        </div>
    </div>
@endsection