<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') &mdash; Bewerbungscoaching</title>

    <style>
        body {
            padding: 2rem;
            font-family: sans-serif;
        }

        a {
            color: grey;
        }

        .email-header {
        }

        .email-content {
            background: #ececec;
            margin: 10px;
            padding: 10px;
            overflow: hidden;
            border-radius: 5px;
            font-size: 15px;
        }

        .email-footer {
            margin: 10px;
            padding: 10px;
            table-layout: fixed;
            height: 100%;
            font-size: 12px;
            color: #bbbbbb;
        }
    </style>
</head>

<body>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" class="email-header">
                <tr>
                    <td>
                        LOGO
                    </td>
                </tr>
            </table>
            <table width="600" cellpadding="0" cellspacing="0" border="0" class="email-content">
                @yield('content')
            </table>
            <table width="600" cellpadding="0" cellspacing="0" border="0" class="email-footer">
                <thead>
                <tr>
                    <th align="center">
                        Contact
                    </th>
                    <th align="center">
                        Social Networks
                    </th>
                    <th align="center">
                        Offers
                    </th>
                </tr>
                </thead>
                <tr>
                    <td align="center">
                        <br>
                        You can contact us <a href="">here</a><br>
                        or call us via +49 1234 56789.
                    </td>
                    <td align="center">
                        <br>
                        Follow us on <br>
                        <a href="https://www.facebook.com"><img src="https://cdn1.iconfinder.com/data/icons/logotypes/32/square-facebook-32.png"
                                                                alt="Facebook" title="Facebook"/></a>
                        <a href="https://www.twitter.com"><img src="https://cdn1.iconfinder.com/data/icons/logotypes/32/square-twitter-32.png" alt="Twitter"
                                                               title="Twitter"/></a>
                        <a href="https://www.youtube.com"><img src="https://cdn1.iconfinder.com/data/icons/logotypes/32/youtube-32.png" alt="Youtube"
                                                               title="Youtube"/></a>
                    </td>
                    <td align="center">
                        <br>
                        <a href="">Seminars</a><br>
                        <a href="">Individualcoaching</a><br>
                        <a href="">Application Layouts</a><br>
                        <a href="">Application Packages</a>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="3">
                        <br><br><br>

                        <h3>Datenschutzhinweise</h3>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
