@extends('layouts.backend')

@section('title', $post->exists ? 'Editing '.$post->title : 'Create New Blog Post')

@section('content')

@endsection