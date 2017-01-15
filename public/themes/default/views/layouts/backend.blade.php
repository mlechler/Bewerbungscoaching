<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title') &mdash; Bewerbungscoaching</title>

        <link rel="stylesheet" type="text/css" href="{{ theme('css/backend.css') }}">
        <script src="{{ theme('js/all.js') }}"></script>
    </head>
    <body>
        <nav class="navbar navbar-static-top navbar-inverse">
            <div class="container">
                <div class="navbar-header"><a href="/" class="navbar-brand">Bewerbungscoaching</a></div>
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" role="button" id="usersMenu" data-toggle="dropdown">Users <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="usersMenu">
                            <li><a href="{{ route('employees.index') }}">Employees</a></li>
                            <li><a href="{{ route('members.index') }}">Members</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" role="button" id="productsMenu" data-toggle="dropdown">Products <span class="caret"></span></a>
                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="productsMenu">
                            <li class="dropdown-submenu">
                                <a href="">Seminars</a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="seminarsMenu">
                                    <li><a href="{{ route('seminars.index') }}">Overview Seminars</a></li>
                                    <li><a href="{{ route('seminarappointments.index') }}">Overview Appointments</a></li>
                                    <li><a href="{{ route('seminarbookings.index') }}">Overview Bookings</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('individualcoachings.index') }}">Individual Coaching</a></li>
                            <li><a href="#">Application Packages</a></li>
                            <li><a href="#">Application Layouts</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" role="button" id="discountsMenu" data-toggle="dropdown">Discounts <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="discountsMenu">
                            <li><a href="{{ route('discounts.index') }}">Overview Discounts</a></li>
                            <li><a href="{{ route('memberdiscounts.index') }}">Overview Memberdiscounts</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('invoices.index') }}">Invoices</a></li>
                    <li><a href="{{ route('pages.index') }}">Pages</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog Posts</a></li>
                    <li><a href="{{ route('todo.index') }}">Tasks</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><span class="navbar-text">Hello, {{ $backendUser->firstname }}</span></li>
                    <li><a href="/employee/logout">Logout</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if($__env->yieldContent('title') != 'Dashboard')
                        <h3>@yield('title')</h3>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    @if($errors->count() == 1)
                                        {{ $error }}
                                    @else
                                    <li>{{ $error }}</li>
                                    @endif
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