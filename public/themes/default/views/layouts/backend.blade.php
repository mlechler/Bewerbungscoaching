<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title') &mdash; Bewerbungscoaching</title>

        <link rel="stylesheet" type="text/css" href="{{ theme('css/backend.css') }}">
    </head>
    <body>
        <nav class="navbar navbar-static-top navbar-inverse">
            <div class="container">
                <div class="navbar-header"><a href="/" class="navbar-brand">Bewerbungscoaching</a></div>
                <ul class="nav navbar-nav">
                    <li><a href="/admin/employees">Employees</a></li>
                    <li><a href="/admin/members">Members</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><span class="navbar-text">Hello, {{ $admin->firstname }}</span></li>
                    <li><a href="/auth/logout">Logout</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3>@yield('heading')</h3>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <strong>We found some errors!</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if($status)
                        <div class="alert alert-success">
                            {{ $status }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>

    </body>
</html>