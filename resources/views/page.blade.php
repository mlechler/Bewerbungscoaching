@extends('layouts.frontend')

@section('title', $page->title)

@section('content')
    {!! $page->contentHtml() !!}
@endsection