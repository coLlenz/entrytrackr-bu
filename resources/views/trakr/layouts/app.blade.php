<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Entrytrakr') }}</title>
    <link rel="icon" href="{{ asset('img/favi.ico') }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('font/iconsmind-s/css/iconsminds.css') }}" />
    <link rel="stylesheet" href="{{ asset('font/simple-line-icons/css/simple-line-icons.css') }}" />
    @if(Route::currentRouteName() != 'qr-login-view')
    <link rel="stylesheet" href="{{ asset('fontawesome/css/font-awesome.min.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dore.light.purple.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/component-custom-switch.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/question.css') }}" />
    @yield('style')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <style media="screen">
        .bg{
            background:#A68BD9;
            /* background: linear-gradient(90deg, rgba(41,91,136,1) 4%, rgba(177,46,177,1) 35%, rgba(110,82,212,1) 93%); */
            background-size: auto; 
            opacity: 20%; 
            background-size: cover;
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner fullscreen_window">
    <div class="bg" style=""></div>
    <img src="https://qrlogins.s3-ap-southeast-2.amazonaws.com/img/entrytrakr-white.png" style="position: absolute;margin-top: -80px; width: 10rem; height:auto;"  class="ml-3">
    <div id="app" style="">
        <main class="py-4" style="margin-left:0px !important; margin-right:0px !important;margin-top:100px !important">
            @yield('content')
        </main>
        @include('trakr.components.footer')
    </div>

    <script src="{{ asset('js/vendor/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/vendor/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/dore.script.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    @yield('script')
</body>

</html>
