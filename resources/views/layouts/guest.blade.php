<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="NJ Car Rentals - Authentication">
    <title>@yield('title') - NJ Car Rentals</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('styles')
</head>

<body class="theme-transition">
<div id="top"></div>

<!-- EXACT Navbar Copy from app.blade.php -->
<nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('images/njcarrentallogo-removebg-preview.png') }}" alt="NJ Car Rentals" class="brand-logo me-3" style="height: 36px;">
            <span class="brand-name">Car Rentals</span>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house-door me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vehicles.rental*') ? 'active' : '' }}" href="{{ route('vehicles.rental') }}">
                        <i class="bi bi-car-front me-1"></i> For Rent
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vehicles.sale*') ? 'active' : '' }}" href="{{ route('vehicles.sale') }}">
                        <i class="bi bi-tag me-1"></i> For Sale
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact*') ? 'active' : '' }}" href="{{ route('contact') }}">
                        <i class="bi bi-envelope me-1"></i> Contact
                    </a>
                </li>
            </ul>

            <!-- Compact Search -->
            <form class="d-none d-lg-flex me-3" role="search" method="GET" action="{{ route('vehicles.index') }}">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-sm" type="search" name="q" placeholder="Search vehicles">
                    <button class="btn btn-outline-secondary btn-sm" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- Guest Auth Buttons (SIMPLE - Matches main app.blade.php) -->
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('customer.login') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Login
                </a>
                <a href="{{ route('customer.register') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-person-plus me-1"></i>Register
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Content with Perfect Spacing (Identical to main pages) -->
<main style="padding-top: 5rem;">
    <div class="container">
        @yield('content')
    </div>
</main>

<!-- Scripts (Identical to app.blade.php) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>

@yield('scripts')

@stack('scripts')
</body>
</html>
