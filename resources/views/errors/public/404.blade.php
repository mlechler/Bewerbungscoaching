@extends('layouts.frontend')

@section('content')
    <div class="error">
        The requested url <br>
        <strong>{{ "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" }}</strong> <br>
        was not found. <br>
        <a style="font-size: 25px;" href="/">Back to home</a>
    </div>
@endsection