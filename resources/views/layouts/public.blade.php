<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RamadhanFest - MSP') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="hold-transition layout-top-nav">

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/assets/img/msp-logo.png" height="40" alt="Logo"> <b>Ramadhan Fest</b>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">

                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('event') }}">Event</a>
                        </li>
                        @if(Session::has('member'))
                        <li>
                            <a class="nav-link" href="{{ route('public.members.login_success') }}">My Profile</a>
                        </li>
                        @elseif(Session::has('relawan'))
                        <li>
                            <a class="nav-link" href="{{ route('public.relawans.login_success') }}">My Profile</a>
                        </li>
                        @else
                        <li>
                            <a class="nav-link" href="{{ route('public.members.index') }}">Daftar</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('public.members.login') }}">Login</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="content m-5">
            @yield('content')
        </main>
    </div>
</body>
</html>
