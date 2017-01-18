@extends('layouts.backend')

@section('title', 'Details of '.$member->getName())

@section('content')
    {{ Form::model($member, [
     'method' => 'post',
     'route' => ['members.uploadCheckedFile', $member->id],
     'enctype' => 'multipart/form-data'
     ]) }}
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Lastname</h4>
            </td>
            <td>
                <h4>{{ $member->lastname }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Firstname</h4>
            </td>
            <td>
                <h4>{{ $member->firstname }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Birthday</h4>
            </td>
            <td>
                <h4>{{ $member->formatBirthday() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Phone</h4>
            </td>
            <td>
                <h4>{{ $member->phone }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Mobile</h4>
            </td>
            <td>
                <h4>{{ $member->mobile }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Email</h4>
            </td>
            <td>
                <h4>{{ $member->email }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Adress</h4>
            </td>
            <td>
                <h4>{{ $member->formatAdress($member->adress) }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Job</h4>
            </td>
            <td>
                <h4>{{ $member->job }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Employer</h4>
            </td>
            <td>
                <h4>{{ $member->employer }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>University</h4>
            </td>
            <td>
                <h4>{{ $member->university }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Course Of Studies</h4>
            </td>
            <td>
                <h4>{{ $member->courseofstudies }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Role</h4>
            </td>
            <td>
                <h4>{{ $member->role->display_name }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Files</h4>
            </td>
            <td>
                @foreach($member->memberFiles as $file)
                    <div class="row">
                        <div class="col-md-5">
                            {{ $file->name }}
                            <br>
                            <!-- <label class="custom-file-upload"> -->
                                {{ Form::file('checkedFiles['.$file->id.']', null, ['class' => 'form-control']) }}
                            <!--    Upload checked file
                            </label>
                            <span class="file-selected">Nothing selected</span> -->
                            <br><br>
                        </div>
                        <div class="col-md-2">
                            <span class="glyphicon glyphicon-{{ $file->checked ? 'ok' : 'remove' }}"></span>
                            {{ $file->checked ? 'checked' : 'not checked' }}
                        </div>
                    </div>
                @endforeach
                @if(!$member->memberFiles->isEmpty())
                    <p class="help-block">
                        The checked files have to have the same name as the original one.
                    </p>
                @endif
            </td>
        </tr>
        </tbody>
    </table>
    {{ Form::submit('Upload Checked Files', ['class' => 'btn btn-success']) }}
    <a href="{{ route('members.index') }}" class="btn btn-danger">Back</a>
    {{ Form::close() }}
@endsection