@extends('layouts.backend')

@section('title', 'Details of VALUE')

@section('content')
    {{ Form::model($packagepurchase, [
     'method' => 'post',
     'route' => ['packagepurchases.uploadPackageFile', $packagepurchase->id],
     'enctype' => 'multipart/form-data'
     ]) }}
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>
                <h4>Member</h4>
            </td>
            <td>
                <h4>{{ $packagepurchase->member->getName() }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Package</h4>
            </td>
            <td>
                <h4>{{ $packagepurchase->applicationpackage->title }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Price</h4>
            </td>
            <td>
                <h4>{{ $packagepurchase->price_incl_discount }} €</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Paid</h4>
            </td>
            <td>
                <h4><span class="glyphicon glyphicon-{{ $packagepurchase->paid ? 'ok' : 'remove' }}"></span></h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>File</h4>
            </td>
            <td>
                @if($packagepurchase->path)
                    <div class="row">
                        <div class="col-md-3">
                            {{ $packagepurchase->getFilename() }}
                        </div>
                        <div class="col-md-1">
                            <a href="{{ route('packagepurchases.deleteFile', $packagepurchase->id) }}"><span
                                        class="glyphicon glyphicon-remove"></span></a></div>
                    </div>
                    <br>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <label class="btn btn-default btn-file">
                            Browse File
                            {{ Form::file('package', ['class' => 'form-control', 'id' => 'package']) }}
                        </label>
                        <span id="packageFilename"></span>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    {{ Form::submit('Upload Package File', ['class' => 'btn btn-success']) }}
    <a href="{{ route('packagepurchases.index') }}" class="btn btn-danger">Back</a>
    {{ Form::close() }}

    <script>
        $('#package').on('change', function () {
            var pathParts = $(this).val().split('\\');
            var fileName = pathParts[pathParts.length-1];
            $('#packageFilename').html(fileName);
        });
    </script>
@endsection