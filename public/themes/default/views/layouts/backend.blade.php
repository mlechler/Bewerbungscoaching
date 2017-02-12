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
        <div class="navbar-header"><a href="/" class="navbar-brand">Home</a></div>
        <ul class="nav navbar-nav">
            <li><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
            <li class="dropdown">
                <a href="">Users <span class="caret"></span></a>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="usersMenu">
                    <li class="dropdown-submenu">
                        @if($backendUser->isAdmin())
                            <a href="">Employees</a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="employeesMenu">
                                <li><a href="{{ route('employees.index') }}">Overview Employees</a></li>
                                <li><a href="{{ route('employeefreetimes.index') }}">
                                        Overview Employee Free Times
                                    </a></li>
                            </ul>
                    </li>
                    @endif
                    <li><a href="{{ route('members.index') }}">Members</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="">Products <span class="caret"></span></a>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="productsMenu">
                    <li class="dropdown-submenu">
                        <a href="">Seminars</a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="seminarsMenu">
                            <li><a href="{{ route('seminars.index') }}">Overview Seminars</a></li>
                            <li><a href="{{ route('seminarappointments.index') }}">
                                    @if($backendUser->isAdmin())
                                        Overview Appointments
                                    @else
                                        My Appointments
                                    @endif
                                </a></li>
                            @if($backendUser->isAdmin())
                                <li><a href="{{ route('seminarbookings.index') }}">Overview Bookings</a></li>
                            @endif
                        </ul>
                    </li>
                    <li><a href="{{ route('individualcoachings.index') }}">Individual Coaching</a></li>
                    <li class="dropdown-submenu">
                        <a href="">Application Packages</a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="applicationPackagesMenu">
                            <li><a href="{{ route('applicationpackages.index') }}">Overview Application Packages</a>
                            </li>
                            @if($backendUser->isAdmin())
                                <li><a href="{{ route('packagepurchases.index') }}">Overview Package Purchases</a></li>
                            @endif
                        </ul>
                    </li>
                    @if($backendUser->isAdmin())
                        <li class="dropdown-submenu">
                            <a href="">Application Layouts</a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="applicationLayoutsMenu">
                                <li><a href="{{ route('applicationlayouts.index') }}">Overview Application Layouts</a>
                                </li>
                                <li><a href="{{ route('layoutpurchases.index') }}">Overview Layout Purchases</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </li>
            @if($backendUser->isAdmin())
                <li class="dropdown">
                    <a href="">Discounts <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="discountsMenu">
                        <li><a href="{{ route('discounts.index') }}">Overview Discounts</a></li>
                        <li><a href="{{ route('memberdiscounts.index') }}">Overview Member Discounts</a></li>
                    </ul>
                </li>
            @endif
            @if($backendUser->isAdmin())
                <li><a href="{{ route('invoices.index') }}">Invoices</a></li>
            @endif
            @if($backendUser->isAdmin())
                <li><a href="{{ route('pages.index') }}">Pages</a></li>
            @endif

            <li><a href="{{ route('blog.index') }}">Blog Posts</a></li>
            <li><a href="{{ route('todo.index') }}">Tasks</a></li>
            <li><a href="{{ route('contact.index') }}">Contact Requests</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><span class="navbar-text">
            <li class="dropdown">
                <a href="">Hello, {{ $backendUser->firstname }} <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="userMenu">
                    <li><a href="{{ route('employees.detail', $backendUser->id) }}">My Information</a></li>
                    @if(!$backendUser->isAdmin())
                        <li><a href="{{ route('employeefreetimes.index') }}">My Free Times</a></li>
                    @endif
                </ul>
            </li>
            </span></li>
            <li><a href="{{ route('employee.logout') }}">Logout</a></li>
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