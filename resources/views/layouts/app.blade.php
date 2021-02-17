<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EntryTrakr') }}</title>
    <link rel="icon" href="{{ asset('img/favi.ico') }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/question.css') }}" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{ asset('font/iconsmind-s/css/iconsminds.css') }}" />
    <link rel="stylesheet" href="{{ asset('font/simple-line-icons/css/simple-line-icons.css') }}" />
     -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/font-awesome.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dore.light.purple.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/component-custom-switch.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/perfect-scrollbar.css') }}" />
    @yield('style')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
</head>

<body id="app-container" class="menu-sub-hidden show-spinner">
    <div id="app">
        @include('components.topnavbar')
        @include('components.menu')
        <main class="py-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        {{-- @include('components.breadcrumbs') --}}
                        
                        @yield('content')
                    </div>
                </div>
            </div>
            
        </main>
        @include('components.footer')
    </div>
    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}

    <script src="{{ asset('js/vendor/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/vendor/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/dore.script.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    @yield('script')
</body>

</html>
