@extends('layouts.backend')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-6">
            {{ Widget::run('todo') }}
        </div>
        <div class="col-md-6">
            {{ Widget::run('recentEmployees') }}
            {{ Widget::run('recentMembers') }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {{ Widget::run('recentPosts') }}
        </div>
        <div class="col-md-6">
            {{ Widget::run('paypalTransactions')}}
        </div>
    </div>
@endsection