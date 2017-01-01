<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title') &mdash; Bewerbungscoaching</title>

        <link rel="stylesheet" type="text/css" href="{{ theme('css/backend.css') }}">
    </head>
    <body>
        <div class="container">
            <div class="row vertical-center">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel panel-{{$errors->any() ? 'danger' : 'default'}}">
                        <div class="panel-heading">
                            <h2 class="panel-title">@yield('title')</h2>
                        </div>
                        <div class="panel-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </body>
</html>