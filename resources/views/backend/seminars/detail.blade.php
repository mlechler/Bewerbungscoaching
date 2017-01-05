@extends('layouts.backend')

@section('title', 'Details of '.$seminar->title)

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Title</h4>
            </td>
            <td>
                <h4>{{ $seminar->title }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Services</h4>
            </td>
            <td>
                <h4>{{ $seminar->services }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Maximum Participants</h4>
            </td>
            <td>
                <h4>{{ $seminar->maxMembers }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Duration</h4>
            </td>
            <td>
                <h4>{{ $seminar->duration }} minutes</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Price</h4>
            </td>
            <td>
                <h4>{{ $seminar->price }} €</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Description</h4>
            </td>
            <td>
                <h4>{{ $seminar->description }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Files</h4>
            </td>
            <td>
                @foreach($seminar->seminarFiles as $file)
                    {{ $file->name }}
                @endforeach
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('seminars.index') }}" class="btn btn-danger">Back</a>
@endsection