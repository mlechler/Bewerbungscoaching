@extends('layouts.backend')

@section('title', 'Details of '.$member->getName())

@section('content')
    {{ Form::model($member, [
    'name' => 'memberDetails',
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
                <h4>Address</h4>
            </td>
            <td>
                <h4>{{ $member->formatAddress() }}</h4>
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
                            <a href="{{ $file->download }}" target="_blank">{{ $file->name }}</a>
                            <br><br>
                        </div>
                        <div class="col-md-2">
                            <span class="glyphicon glyphicon-{{ $file->checked ? 'ok' : 'remove' }}"></span>
                            {{ $file->checked ? 'checked' : 'not checked' }}
                        </div>
                    </div>
                @endforeach
                <div class="row">
                    <div class="col-md-12">
                        <label class="btn btn-default btn-file">
                            Browse Files
                            {{ Form::file('checkedFiles[]', ['multiple' => 'multiple', 'class' => 'form-control', 'id' => 'checkedFiles']) }}
                        </label>
                        <span id="filenames"></span>
                    </div>
                </div>
                @if(!$member->memberFiles->isEmpty())
                    <p class="help-block">
                        The checked files have to have the same name as the original one.
                    </p>
                @endif
            </td>
        </tr>
        </tbody>
    </table>
    @if(!$member->memberFiles->isEmpty())
        {{ Form::submit('Upload Checked Files', ['class' => 'btn btn-success']) }}
    @endif
    <a href="{{ route('members.index') }}" class="btn btn-danger">Back</a>
    {{ Form::close() }}

    <script>
        $('input[id=checkedFiles]').change(function() {
            var names = [];
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
                names.push(', ');
            }
            names.splice(-1,1);
            $('#filenames').html(names);
        });
    </script>
@endsection