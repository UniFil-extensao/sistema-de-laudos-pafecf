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
            background-color: #ff8f00;
            color: black;
            font-family: 'Nunito', sans-serif;
            font-weight: 200px;
            height: 100vh;
            margin: 0px;
        }

        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .page-dark.layout-full {
            color: #ddd;
        }

        body {
            font-weight: 300px;
            font-size: 14px;
            line-height: 1.57142857;
            color: white;
            background-color: #ff8f00;
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
            margin-top: 15em;
            border-radius: 55px;
            width: 464px;
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
            height: 15em;
            width: 16em;
            margin-right: 3em;
            margin-left: 3em;
            position: center;
        }

        #google_sigIn {
            height: 4em;
            width: 16em;
            position: center;
            margin-top: 10em;
        }

        .sla {
            vertical-align: middle;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
    </style>
</head>

<body>

    <div class="sla">
        <div class="content" style="background-color: #ddd; margin: 0 auto;">

            <img id="pafecf" src="{{ url('img\logoPAFECFUNIFIL.png') }}">
            <div style="padding-bottom: 4em">
                <a href="{{ route('google') }}"><img id="google_sigIn" src="{{ url('img\signin-button.png') }}"></a>
            </div>
        </div>
    </div>
</body>

</html>
