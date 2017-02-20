@extends('layouts.auth')

@section('title', 'Update Password')

@section('content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form class="form-horizontal" role="form" method="POST" action="{{ route('member.password.update') }}">
        {{ csrf_field() }}

        <input type="hidden" name="email" value="{{ $loggedInUser->email }}">

        <div class="form-group{{ $errors->has('oldpw') ? ' has-error' : '' }}">
            <label for="old_password" class="col-md-4 control-label">Old Password</label>

            <div class="col-md-6">
                <input id="old_password" type="password" class="form-control" name="old_password"
                       required autofocus>

                @if ($errors->has('oldpw'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('oldpw') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">New Password</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                       required>

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Update Password
                </button>
            </div>
        </div>
    </form>
@endsection
