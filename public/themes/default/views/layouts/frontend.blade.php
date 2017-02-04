<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') &mdash; Bewerbungscoaching</title>

    <link rel="stylesheet" type="text/css" href="{{ theme('css/frontend.css') }}">
    <script src="{{ theme('js/all.js') }}"></script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a href="/" class="navbar-brand">
                <img src="images/logo.png" alt="Bewerbungscoaching">
            </a>
        </div>
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a href="">Item 1 <span class="caret"></span></a>
                <ul class="dropdown-menu multi-level" role="menu">
                    <li class="dropdown-submenu">
                        <a href="">Item 1.1</a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('seminars.index') }}">Overview Seminars</a></li>
                        </ul>
                    </li>
                </ul>
            <li><a href="#">Item 2</a></li>
            <li><a href="#">Item 3</a></li>
            @include('partials.staticpagesnavigation')
        </ul>
        <ul class="nav navbar-nav navbar-right">
            @if($loggedInUser)
                <li><span class="navbar-text">
                <li class="dropdown">
                    <a href="">Hello, {{ $loggedInUser->firstname }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="userMenu">
                        <li><a href="">My Information</a></li>
                    </ul>
                </li>
                </span></li>
                <li><a href="/member/logout">Logout</a></li>
            @else
                <li><a href="/member/login">Login</a></li>
            @endif
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>