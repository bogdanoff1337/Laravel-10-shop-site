<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto:wght@400;500;700;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-light fixed-top">
            <!-- Назва сайту ліворуч -->
            <a class="navbar-brand text-light" href="{{ url('/') }}">
                {{ config('app.name', 'Shop-site') }}
            </a>


            {{-- <form class="d-flex mx-auto" role="search" id="searchForm">
                    <input class="form-control me-2" type="text" id="searchInput" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form> --}}

            {{-- <div id="searchResults" class="mx-auto mt-2"></div> --}}

            <!-- Left Side Of Navbar -->


            <!-- Right Side Of Navbar -->
            <div class="navbar-nav">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <a class="btn-main  mx-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                    @endif
                    @if (Route::has('register'))
                        <a class="btn-main" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                @else
                    {{-- @if (Auth::check())
                                    <a class="btn " href="{{ route('cart.index') }}">
                                        <i class="bi bi-cart-fill">{{ $cartCount }}</i>
                                    </a>
                                    <a class="btn " href="">
                                        <i class="bi bi-bookmark"></i>
                                    </a>
                                @endif --}}
                    <a class="btn-main mx-2" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right">{{ __('Logout') }}</i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                @endguest
            </div>

    </div>
    </nav>
    <main class="py-6 mt-5">
        @yield('content')
    </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
