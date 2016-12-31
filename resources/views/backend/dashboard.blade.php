@extends('layouts.backend')

@section('title', 'Dashboard')

@section('heading','Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-6">@widget('recentPosts')</div>
        <div class="col-md-6"></div>
    </div>
@endsection