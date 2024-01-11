<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">

   

    <link rel="stylesheet" href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-dark shadow-sm fixed-top">
            <div class="container d-flex justify-content-between align-items-center">
                <!-- Назва сайту ліворуч -->
                <a class="navbar-brand text-light" href="{{ url('/') }}">
                    {{ config('app.name', 'Shop-site') }}
                </a>

                
                <form class="d-flex mx-auto" role="search" id="searchForm">
                    <input class="form-control me-2" type="text" id="searchInput" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                
                <div id="searchResults" class="mx-auto mt-2"></div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                      
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <a class="btn btn-primary mx-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @endif
                            @if (Route::has('register'))
                                <a class="btn btn-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        @else
                            <a class="nav-link text-light mx-4" href="#">
                                Welcome {{ Auth::user()->name }}
                            </a>
                            <div class="btn-group">
                                <a class="btn btn-secondary" href="{{ route('cart.details') }}">
                                    My Orders
                                </a>
                                @if(auth()->user()->is_admin == 1)
                                    <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">
                                        Dashboard
                                    </a>
                                    <a class="btn btn-secondary" href="{{ route('products.create') }}">
                                        Add Products
                                    </a>
                                @endif

                                @if(Auth::check())
                                    {{-- <a class="btn btn-secondary" href="{{ route('cart.show') }}">
                                        <i class="bi bi-cart-fill">{{ $cartCount }}</i>
                                    </a> --}}
                                    <a class="btn btn-secondary" href="">
                                        <i class="bi bi-bookmark"></i>
                                    </a>
                                @endif
                            </div>
                            <a class="btn btn-danger mx-2" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right">{{ __('Logout') }}</i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4 mt-5">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
