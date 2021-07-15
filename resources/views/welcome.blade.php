<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ asset('assets/img/brand/favicon.png') }}" type="image/png">
        <title>SMK Darul Mawa</title>
        <meta name="keywords" content="SMK Darul Mawa | E-Learning"/>
        <meta name="description" content="E-Learning untuk siswa siswi SMK Darul Mawa"/>
        <meta name="language" content="ES">
        <meta name="robots" content="index,follow" />
        <meta name="author" content="SMK Darul Mawa, admin@smkdarulmawa.com">
        <meta name="url" content="http://www.smkdarulmawa.com">
        <meta name="identifier-URL" content="http://www.smkdarulmawa.com">
        <meta name="coverage" content="Worldwide">
        <meta name="distribution" content="Global">
        <meta name="rating" content="General">
        <meta name="revisit-after" content="7 days">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta name="og:title" content="SMK Darul Mawa | E-Learning"/>
        <meta name="og:type" content="website"/>
        <meta name="og:url" content="http://www.smkdarulmawa.com/"/>
        <meta name="og:image" content="{{ asset('assets/img/brand/favicon.png') }}"/>
        <meta name="og:site_name" content="SMK Darul Mawa"/>
        <meta name="og:description" content="E-Learning untuk siswa siswi SMK Darul Mawa"/>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    SMK Darul Mawa
                </div>
            </div>
        </div>
    </body>
</html>
