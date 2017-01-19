@extends('layouts.backend')

@section('title', 'Details of '.$task->title)

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Title</h4>
            </td>
            <td>
                <h4>{{ $task->title }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Creator</h4>
            </td>
            <td>
                <h4>{{ $task->getName() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Finished</h4>
            </td>
            <td>
                <h4><span class="glyphicon glyphicon-{{ $task->finished ? 'ok' : 'remove'}}"></span></h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Description</h4>
            </td>
            <td>
                <h4>{!! $task->descriptionHtml() !!}</h4>
            </td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('todo.finishedTask', $task->id) }}" class="btn btn-success">Task is finished</a>
    <a href="{{ route('todo.index') }}" class="btn btn-danger">Back</a>
@endsection