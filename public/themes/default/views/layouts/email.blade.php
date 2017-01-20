<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') &mdash; Bewerbungscoaching</title>

    <style>
        body {
            padding-bottom: 2rem;
            padding-top: 2rem;
        }

        .email-container {
            background: #ececec;
            font-family: sans-serif;
            margin: 0;
            overflow: hidden;
            border-radius: 5px;
        }
    </style>
</head>

<body>
<div class="email-background">
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0" class="email-container">
                    <tr>
                        <td>
                            LOGO
                        </td>
                    </tr>
                    @yield('content')
                    <tr>
                        <td>
                            Sonstige Infos (Kontakt, Social networks, etc.)
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
