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
        <div class="col-md-6">
            {{ Widget::run('contactRequests') }}
        </div>
    </div>
    {{--@if($backendUser->isAdmin())--}}
        {{--<div class="row">--}}
            {{--{{ Widget::run('paypalTransactions')}}--}}
        {{--</div>--}}
    {{--@endif--}}
@endsection