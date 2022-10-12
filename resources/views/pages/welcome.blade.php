<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>PAF-ECF</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #ddd;
            color: black;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .page-login .page-login-main {
            position: absolute;
            top: 0;
            right: 0;
            height: auto;
            min-height: 100%;
            padding: 50px 60px 60px;
            color: black;
            background: #ddd;
        }

        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        user agent stylesheet div {
            display: block;
        }

        .page-dark.layout-full {
            color: #ddd;
        }

        body {
            font-weight: 300;
            font-size: 14px;
            line-height: 1.57142857;
            color: white;
            background-color: #ddd;
        }

        html {
            font-size: 10px;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            font-family: 'Nunito', sans-serif;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        *:before,
        *:after {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
            margin-top: 2em;
        }

        .home {
            margin: 25px 50px 0px 0px;
        }

        .home>a {
            color: white;
            font-family: 'Nunito', sans-serif;
            font-size: 16px;
            letter-spacing: .1rem;
            text-decoration: none;

        }

        .enter>a {
            color: white;
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            letter-spacing: .1rem;
            text-decoration: none;
        }

        .enter {
            display: inline-flex;
            justify-content: flex-end;
            margin: 25px 50px 0px 0px;
        }

        #pafecf {
            height: 250px;
            width: 275px;
            margin-right: 30px;
            position: center;
        }

        #google_sigIn {
            height: 4em;
            width: 16em;
            position: center;
        }
    </style>
</head>

<body>
    <div class="content">

        <img style="" id="pafecf" src="{{ url('img\logoPAFECFUNIFIL.png') }}">
        <div>
            <a href="{{ route('google') }}"><img id="google_sigIn" src="{{ url('img\signin-button.png') }}"></a>
        </div>
    </div>
</body>

</html>
