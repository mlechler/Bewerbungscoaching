@extends('layouts.backend')

@section('title', 'Details of VALUE')

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Name</h4>
            </td>
            <td>
                <h4>{{ $contactrequest->name }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Email</h4>
            </td>
            <td>
                <h4>{{ $contactrequest->email }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Employee</h4>
            </td>
            <td>
                @if($contactrequest->employee_id)
                    <h4>{{ $contactrequest->employee->getName() }}</h4>
                @else
                    <h4>All</h4>
                @endif
            </td>
        </tr>
        <tr>
            <td>
                <h4>Category</h4>
            </td>
            <td>
                <h4>{{ $contactrequest->category }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Message</h4>
            </td>
            <td>
                <h4>{!! $contactrequest->messageHtml() !!}</h4>
            </td>
        </tr>
        @if($contactrequest->category != 'feedback')
            <tr>
                <td>
                    <h4>In Processing</h4>
                </td>
                <td>
                    <h4>
                        <span class="glyphicon glyphicon-{{ $contactrequest->processing ? 'ok' : 'remove'}}"></span> {{ $contactrequest->processing ? ' by ' . $contactrequest->processedBy() : null}}
                    </h4>
                </td>
            </tr>
            <tr>
                <td>
                    <h4>Finished</h4>
                </td>
                <td>
                    <h4><span class="glyphicon glyphicon-{{ $contactrequest->finished ? 'ok' : 'remove'}}"></span></h4>
                </td>
            </tr>
        @endif
        </tbody>
    </table>
    @if($contactrequest->category != 'feedback')
        @if (!$contactrequest->processing && !$contactrequest->finished)
            <a href="{{ route('contact.processRequest', $contactrequest->id) }}" class="btn btn-warning">Process Contact
                Request</a>
        @endif
        @if(!$contactrequest->finished)
            <a href="{{ route('contact.finishedRequest', $contactrequest->id) }}" class="btn btn-success">Contact
                Request is
                finished</a>
        @endif
    @endif
    <a href="{{ route('contact.index') }}" class="btn btn-danger">Back</a>
@endsection