@extends('layouts.frontend')

@section('title', 'Application Documents')

@section('content')
    <div class="row">
        <a href="{{ route('frontend.applicationpackages.index') }}">
            <div class="col-md-6">
                <div class="panel panel-default vertical-center">
                    <div class="panel-body" align="center">
                        <h1>Application Packages</h1>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('frontend.applicationlayouts.index') }}">
            <div class="col-md-6">
                <div class="panel panel-default vertical-center">
                    <div class="panel-body" align="center">
                        <h1>Application Layouts</h1>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endsection