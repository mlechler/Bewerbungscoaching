@extends('layouts.frontend')

@section('title', $page->title)

@section('content')
    {!! $page->contentHtml() !!}

    @if($page->uri == 'contact')
        @include('frontend.contact', $employees)
    @endif
@endsection