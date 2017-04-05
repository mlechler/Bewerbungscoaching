<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if($__env->yieldContent('title'))
        <title>@yield('title') &mdash; Bewerbungscoaching</title>
    @else
        <title>Bewerbungscoaching</title>
    @endif

    <link rel="stylesheet" type="text/css" href="{{ theme('css/frontend.css') }}">
    <script src="{{ theme('js/all.js') }}"></script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a href="/" class="navbar-brand">
                <img src="{{theme('../../../../images/logo.png')}}" alt="Bewerbungscoaching">
            </a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ route('frontend.seminars.index') }}">Seminars</a></li>
            <li><a href="{{ route('frontend.individualcoachings.index') }}">Individual Coaching</a></li>
            <li class="dropdown">
                <a href="{{ route('frontend.applicationdocuments.index') }}">Application Documents <span
                            class="caret"></span></a>
                <ul class="dropdown-menu multi-level" role="menu">
                    <li><a href="{{ route('frontend.applicationpackages.index') }}">Application Packages</a></li>
                    <li><a href="{{ route('frontend.applicationlayouts.index') }}">Application Layouts</a></li>
                </ul>
            <li><a href="{{ route('frontend.blog.index') }}">Blog</a></li>
            @include('partials.staticpagesnavigation')
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="{{ route('employee.login') }}">Intern</a></li>
            @if($loggedInUser)
                <li class="dropdown">
                    <a href="">Hello, {{ $loggedInUser->firstname }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="userMenu">
                        <li><a href="{{ route('frontend.myinformation.index') }}">My Information</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('member.logout') }}">Logout</a></li>
            @else
                <li><a href="{{ route('member.login') }}">Login</a></li>
            @endif
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if($__env->yieldContent('title') != 'Welcome' && $__env->yieldContent('title') != 'My Information' && $__env->yieldContent('title') != 'Blog Post')
                <h3>@yield('title')</h3>
            @endif

            @if(isset($errors))
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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
<nav class="navbar navbar-default footer">
    <div class="container">
        <ul class="nav navbar-nav">
            <li>
                <a href="">©2017 Bewerbungscoaching | Designed by Marcel Lechler</a>
            </li>
        </ul>
    </div>
</nav>
</body>
</html>