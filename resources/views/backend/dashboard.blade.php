@extends('layouts.backend')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-6">
            {{ Widget::run('todo') }}
        </div>
        @if($backendUser->isAdmin())
            <div class="col-md-6">
                {{ Widget::run('recentEmployees') }}
                {{ Widget::run('recentMembers') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-6">
            {{ Widget::run('recentPosts') }}
        </div>
        @if($backendUser->isAdmin())
            <div class="col-md-6">
                {{ Widget::run('paypalTransactions')}}
            </div>
        @endif
    </div>
@endsection