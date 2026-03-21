@extends('layouts.app')

@section('title', 'Home')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        /* ========================================
           HERO SECTION - Premium Design
           ======================================== */
        .hero-section {
            background: linear-gradient(135deg, #050a12 0%, #0a192f 30%, #112240 70%, #1d3557 100%);
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
            min-height: 85vh;
            display: flex;
            align-items: center;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(ellipse at 20% 80%, rgba(212, 175, 55, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(212, 175, 55, 0.05) 0%, transparent 40%),
                radial-gradient(ellipse at 50% 50%, rgba(17, 34, 64, 0.5) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 45%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d4af37' fill-opacity='0.04'%3E%3Cpath d='M50 50v-10H40v10h-10v10h10v10h10v-10h10v-10h-10zm0-30V10h-10v10h-10v10h10v10h10V20h10V10h-10zM10 50v-10H0v10h-10v10h10v10h10v-10h10v-10H10zM10 10V0H0v10h-10v10h10V10h10V0H10z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.6;
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.3);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            color: #d4af37;
            margin-bottom: 24px;
            animation: fadeInUp 0.6s ease forwards;
        }

        .hero-badge i {
            font-size: 0.75rem;
        }

        .hero-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 4rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 24px;
            line-height: 1.1;
            animation: fadeInUp 0.6s ease forwards;
            animation-delay: 0.1s;
            opacity: 0;
        }

        .hero-title span {
            background: linear-gradient(135deg, #d4af37 0%, #e9c95d 50%, #d4af37 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
        }

        .hero-title span::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, #d4af37, transparent);
            opacity: 0.5;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: #a0aec0;
            margin-bottom: 40px;
            max-width: 520px;
            line-height: 1.7;
            animation: fadeInUp 0.6s ease forwards;
            animation-delay: 0.2s;
            opacity: 0;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
            margin-bottom: 48px;
            animation: fadeInUp 0.6s ease forwards;
            animation-delay: 0.3s;
            opacity: 0;
        }

        .hero-buttons .btn {
            padding: 14px 32px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 12px;
        }

        .hero-stats {
            display: flex;
            gap: 48px;
            animation: fadeInUp 0.6s ease forwards;
            animation-delay: 0.4s;
            opacity: 0;
        }

        .hero-stat {
            text-align: center;
        }

        .hero-stat-number {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: #d4af37;
            line-height: 1;
        }

        .hero-stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 4px;
        }

        /* Hero Carousel */
        .hero-carousel-wrapper {
            position: relative;
            animation: fadeIn 0.8s ease forwards;
            animation-delay: 0.5s;
            opacity: 0;
        }

        .hero-carousel {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4), 0 0 30px rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        .carousel-image {
            width: 100%;
            height: 450px;
            object-fit: cover;
        }

        .hero-carousel .carousel-indicators {
            margin-bottom: 20px;
        }

        .hero-carousel .carousel-indicators button {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.3);
            border: none;
            margin: 0 4px;
        }

        .hero-carousel .carousel-indicators button.active {
            background-color: #d4af37;
            width: 24px;
            border-radius: 10px;
        }

        .hero-carousel .carousel-control-prev,
        .hero-carousel .carousel-control-next {
            width: 50px;
            height: 50px;
            background: rgba(10, 25, 47, 0.8);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            margin: 0 20px;
            opacity: 0;
            transition: all 0.3s ease;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        .hero-carousel:hover .carousel-control-prev,
        .hero-carousel:hover .carousel-control-next {
            opacity: 1;
        }

        .hero-carousel .carousel-control-prev:hover,
        .hero-carousel .carousel-control-next:hover {
            background: #d4af37;
        }

        .hero-carousel .carousel-control-prev-icon,
        .hero-carousel .carousel-control-next-icon {
            background-image: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-carousel .carousel-control-prev-icon::before {
            content: '\F284';
            font-family: 'bootstrap-icons';
            font-size: 1.5rem;
            color: #fff;
        }

        .hero-carousel .carousel-control-next-icon::before {
            content: '\F285';
            font-family: 'bootstrap-icons';
            font-size: 1.5rem;
            color: #fff;
        }

        /* Search Box - Glassmorphism */
        .search-box {
            background: rgba(17, 34, 64, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            margin-top: 20px;
            animation: fadeInUp 0.6s ease forwards;
            animation-delay: 0.25s;
            opacity: 0;
        }

        .search-box .form-label {
            color: #d4af37;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .search-box .form-control,
        .search-box .form-select {
            background: #0a192f;
            border: 1px solid #1d3557;
            border-radius: 10px;
            padding: 14px 16px;
            color: #e8e8e8;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .search-box .form-control:focus,
        .search-box .form-select:focus {
            background: #112240;
            border-color: #d4af37;
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.15);
            color: #fff;
        }

        .search-box .form-control::placeholder {
            color: #5a6a7a;
        }

        .search-box .btn-primary {
            padding: 14px 32px;
            font-weight: 600;
            border-radius: 10px;
        }

        /* ========================================
           FEATURED VEHICLES SECTION
           ======================================== */
        .featured-section {
            padding: 100px 0;
            background: #0a0f1a;
            position: relative;
        }

        .featured-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.3), transparent);
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 2.75rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 16px;
        }

        .section-title span {
            background: linear-gradient(135deg, #d4af37 0%, #e9c95d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            max-width: 550px;
            margin: 0 auto;
        }

        /* Vehicle Cards */
        .featured-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 32px;
        }

        .featured-card {
            background: #112240;
            border: 1px solid #1d3557;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .featured-card:hover {
            transform: translateY(-12px);
            border-color: #d4af37;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.35), 0 0 30px rgba(212, 175, 55, 0.15);
        }

        .featured-image {
            position: relative;
            height: 240px;
            overflow: hidden;
        }

        .featured-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .featured-card:hover .featured-image img {
            transform: scale(1.08);
        }

        .featured-type-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            background: linear-gradient(135deg, #d4af37 0%, #b8962e 100%);
            color: #0a192f;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .featured-availability {
            position: absolute;
            top: 16px;
            right: 16px;
            background: rgba(10, 25, 47, 0.85);
            backdrop-filter: blur(8px);
            color: #10b981;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .featured-info {
            padding: 24px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .featured-name {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.35rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 12px;
        }

        .featured-specs {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #1d3557;
        }

        .featured-spec {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: #8892a0;
        }

        .featured-spec i {
            color: #d4af37;
            font-size: 0.9rem;
        }

        .featured-price {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: #d4af37;
            margin-bottom: 20px;
        }

        .featured-price .period {
            font-size: 0.85rem;
            font-weight: 400;
            color: #6c757d;
        }

        .featured-actions {
            display: flex;
            gap: 12px;
            margin-top: auto;
        }

        .featured-actions a {
            flex: 1;
            padding: 12px 20px;
            text-align: center;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .featured-actions .btn-primary {
            background: linear-gradient(135deg, #d4af37 0%, #b8962e 100%);
            color: #0a192f;
        }

        .featured-actions .btn-primary:hover {
            background: linear-gradient(135deg, #e9c95d 0%, #d4af37 100%);
            color: #0a192f;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.35);
        }

        .featured-actions .btn-secondary {
            background: transparent;
            color: #d4af37;
            border: 2px solid #d4af37;
        }

        .featured-actions .btn-secondary:hover {
            background: #d4af37;
            color: #0a192f;
        }

        .all-vehicles-cta {
            text-align: center;
            margin-top: 60px;
        }

        .all-vehicles-cta a {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 40px;
            background: transparent;
            color: #d4af37;
            border: 2px solid #d4af37;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .all-vehicles-cta a:hover {
            background: #d4af37;
            color: #0a192f;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.3);
        }

        /* ========================================
           WHY CHOOSE US SECTION
           ======================================== */
        .why-choose-section {
            padding: 100px 0;
            background: linear-gradient(180deg, #0a0f1a 0%, #0d1424 100%);
            position: relative;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 32px;
        }

        .feature-item {
            text-align: center;
            padding: 40px 32px;
            background: #112240;
            border: 1px solid #1d3557;
            border-radius: 20px;
            transition: all 0.4s ease;
        }

        .feature-item:hover {
            transform: translateY(-8px);
            border-color: #d4af37;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 25px rgba(212, 175, 55, 0.1);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #d4af37 0%, #b8962e 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #0a192f;
            margin: 0 auto 24px;
            transition: all 0.4s ease;
        }

        .feature-item:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.4);
        }

        .feature-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.35rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 12px;
        }

        .feature-desc {
            color: #8892a0;
            line-height: 1.7;
            font-size: 0.95rem;
            margin: 0;
        }

        /* ========================================
           STATS SECTION
           ======================================== */
        .stats-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #0a192f 0%, #112240 50%, #1d3557 100%);
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d4af37' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            position: relative;
            z-index: 1;
        }

        .stat-item {
            text-align: center;
        }

        .stat-item h3 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 3.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #d4af37 0%, #e9c95d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            line-height: 1;
        }

        .stat-item p {
            font-size: 1rem;
            color: #a0aec0;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 500;
            margin: 0;
        }

        /* ========================================
           CTA SECTION
           ======================================== */
        .cta-section {
            padding: 120px 0;
            background: #0a0f1a;
            text-align: center;
            position: relative;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .cta-content {
            position: relative;
            z-index: 1;
        }

        .cta-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 3rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .cta-title span {
            background: linear-gradient(135deg, #d4af37 0%, #e9c95d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cta-desc {
            font-size: 1.2rem;
            color: #8892a0;
            margin-bottom: 48px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.7;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-buttons a {
            padding: 16px 40px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .cta-buttons .btn-primary {
            background: linear-gradient(135deg, #d4af37 0%, #b8962e 100%);
            color: #0a192f;
        }

        .cta-buttons .btn-primary:hover {
            background: linear-gradient(135deg, #e9c95d 0%, #d4af37 100%);
            color: #0a192f;
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(212, 175, 55, 0.4);
        }

        .cta-buttons .btn-secondary {
            background: transparent;
            color: #d4af37;
            border: 2px solid #d4af37;
        }

        .cta-buttons .btn-secondary:hover {
            background: #d4af37;
            color: #0a192f;
        }

        /* ========================================
           RESPONSIVE DESIGN
           ======================================== */
        @media (max-width: 1200px) {
            .hero-title {
                font-size: 3.25rem;
            }
        }

        @media (max-width: 991px) {
            .hero-section {
                padding: 100px 0 60px;
                min-height: auto;
            }

            .hero-title {
                font-size: 2.75rem;
            }

            .hero-stats {
                justify-content: center;
                gap: 32px;
            }

            .hero-carousel-wrapper {
                margin-top: 40px;
            }

            .carousel-image {
                height: 350px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 32px;
            }

            .stat-item h3 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.25rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .hero-buttons .btn {
                width: 100%;
            }

            .hero-stats {
                flex-wrap: wrap;
                gap: 24px;
            }

            .hero-stat {
                flex: 1 1 40%;
            }

            .section-title {
                font-size: 2rem;
            }

            .featured-grid {
                grid-template-columns: 1fr;
            }

            .cta-title {
                font-size: 2.25rem;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .cta-buttons a {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.875rem;
            }

            .search-box {
                padding: 20px;
            }

            .featured-card {
                border-radius: 16px;
            }
        }
    </style>
@endsection

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <div class="hero-badge">
                        <i class="bi bi-stars"></i>
                        Premium Car Rental Experience
                    </div>
                    
                    <h1 class="hero-title">Your Journey <span>Starts Here</span></h1>
                    <p class="hero-subtitle">
                        Discover premium vehicles for rent and sale. Experience unmatched quality, transparent pricing, and exceptional service in Olongapo.
                    </p>

                    <div class="hero-buttons">
                        <a href="{{ route('vehicles.rental') }}" class="btn btn-primary">
                            <i class="bi bi-car-front me-2"></i>Rent a Car
                        </a>
                        <a href="{{ route('vehicles.sale') }}" class="btn btn-outline-primary">
                            <i class="bi bi-tag me-2"></i>Buy a Car
                        </a>
                    </div>

                    <div class="hero-stats">
                        <div class="hero-stat">
                            <div class="hero-stat-number">20</div>
                            <div class="hero-stat-label">Vehicles</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat-number">100%</div>
                            <div class="hero-stat-label">GPS Enabled</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat-number">200+</div>
                            <div class="hero-stat-label">Customers</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat-number">2</div>
                            <div class="hero-stat-label">Years</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Search Box -->
                <div class="search-box">
                    <form id="searchForm" method="GET" onsubmit="handleSearch(event)">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Type</label>
                                <select id="vehicleType" name="type" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="rental">For Rent</option>
                                    <option value="sale">For Sale</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Search</label>
                                <input type="text" id="searchQuery" name="q" class="form-control" placeholder="Make, model...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Max Price</label>
                                <input type="number" id="maxPrice" name="max_price" class="form-control" placeholder="5000">
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-2"></i>Search Vehicles
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Hero Carousel -->
                <div class="hero-carousel-wrapper mt-4">
                    <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="5000">
                        <div class="carousel-indicators">
                            @forelse($featuredVehicles ?? [] as $key => $fv)
                                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}" aria-current="{{ $key === 0 ? 'true' : 'false' }}"></button>
                            @empty
                                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                            @endforelse
                        </div>
                        <div class="carousel-inner">
                            @php $i = 0; @endphp
                            @forelse($featuredVehicles ?? [] as $fv)
                                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}" data-bs-interval="5000">
                                    @if($fv->image_url)
                                        <img src="{{ $fv->image_url }}" class="d-block w-100 carousel-image" alt="{{ $fv->make }} {{ $fv->model }}">
                                    @else
                                        <div style="background: linear-gradient(135deg, #1d3557 0%, #112240 100%); height: 450px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-car-front" style="font-size: 5rem; color: #d4af37; opacity: 0.5;"></i>
                                        </div>
                                    @endif
                                </div>
                                @php $i++; @endphp
                            @empty
                                <div class="carousel-item active" data-bs-interval="5000">
                                    <div style="background: linear-gradient(135deg, #1d3557 0%, #112240 100%); height: 450px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-car-front" style="font-size: 5rem; color: #d4af37; opacity: 0.5;"></i>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Vehicles Section -->
<div class="featured-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Featured <span>Vehicles</span></h2>
            <p class="section-subtitle">Handpicked selection of premium vehicles ready for your next adventure</p>
        </div>

        <div class="featured-grid">
            @forelse($featuredVehicles ?? [] as $vehicle)
                <div class="featured-card">
                    <div class="featured-image">
                        @if($vehicle->image_url)
                            <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->make }} {{ $vehicle->model }}">
                        @else
                            <div style="background: linear-gradient(135deg, #1d3557 0%, #112240 100%); height: 100%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-car-front" style="font-size: 4rem; color: #d4af37; opacity: 0.3;"></i>
                            </div>
                        @endif
                        <span class="featured-type-badge">{{ ucfirst($vehicle->type) }}</span>
                        <span class="featured-availability {{ $vehicle->status !== 'available' || $vehicle->rented_until ? 'bg-danger text-white' : '' }}" style="background: {{ $vehicle->status !== 'available' || $vehicle->rented_until ? 'linear-gradient(135deg, #ef4444, #dc2626)' : 'rgba(10, 25, 47, 0.85)' }}; color: {{ $vehicle->status !== 'available' || $vehicle->rented_until ? '#fff' : '#10b981' }};">
                            @if($vehicle->status === 'available' && !$vehicle->rented_until)
                                <i class="bi bi-check-circle-fill"></i>Available
                            @elseif($vehicle->rental_status === 'pending')
                                <i class="bi bi-clock-history"></i>{{ $vehicle->rented_until }}
                            @else
                                <i class="bi bi-x-circle"></i>{{ $vehicle->rented_until ?? ucfirst($vehicle->status) }}
                            @endif
                        </span>
                    </div>
                    <div class="featured-info">
                        <div class="featured-name">{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</div>
                        
                        <div class="featured-specs">
                            <div class="featured-spec">
                                <i class="bi bi-gear"></i>{{ ucfirst($vehicle->transmission ?? 'Automatic') }}
                            </div>
                            <div class="featured-spec">
                                <i class="bi bi-people"></i>{{ $vehicle->seats ?? 5 }} Seats
                            </div>
                            <div class="featured-spec">
                                <i class="bi bi-fuel-pump"></i>{{ ucfirst($vehicle->fuel_type ?? 'Gas') }}
                            </div>
                        </div>

                        <div class="featured-price">
                            @if($vehicle->type === 'rental')
                                ₱{{ number_format($vehicle->price_per_day, 2) }}<span class="period">/day</span>
                            @else
                                ₱{{ number_format($vehicle->sale_price, 2) }}
                            @endif
                        </div>

                        <div class="featured-actions">
                            <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn-primary">View Details</a>
                            @if($vehicle->type === 'rental')
                                <a href="{{ route('vehicles.rental') }}" class="btn-secondary">Rent Now</a>
                            @else
                                <a href="{{ route('vehicles.sale') }}" class="btn-secondary">Inquire</a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                    <i class="bi bi-car-front" style="font-size: 4rem; color: #6c757d; opacity: 0.3; margin-bottom: 20px; display: block;"></i>
                    <h3 style="color: #ffffff; margin-bottom: 10px;">No Vehicles Available</h3>
                    <p style="color: #6c757d;">Check back soon for new additions to our fleet.</p>
                </div>
            @endforelse
        </div>

        <div class="all-vehicles-cta">
            <a href="{{ route('vehicles.rental') }}">
                <i class="bi bi-arrow-right"></i>Browse All Vehicles
            </a>
        </div>
    </div>
</div>

<!-- Why Choose Us Section -->
<div class="why-choose-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Why Choose <span>Us</span></h2>
            <p class="section-subtitle">We deliver excellence in every interaction, ensuring your complete satisfaction</p>
        </div>

        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h4 class="feature-title">Full GPS Tracking</h4>
                <p class="feature-desc">Every vehicle equipped with real-time GPS tracking for your peace of mind and security.</p>
            </div>

            <div class="feature-item">
                <div class="feature-icon">
                    <i class="bi bi-clock"></i>
                </div>
                <h4 class="feature-title">24/7 Support</h4>
                <p class="feature-desc">Round-the-clock customer support to assist you anytime, anywhere on your journey.</p>
            </div>

            <div class="feature-item">
                <div class="feature-icon">
                    <i class="bi bi-car-front"></i>
                </div>
                <h4 class="feature-title">Premium Fleet</h4>
                <p class="feature-desc">Well-maintained, modern vehicles carefully selected for comfort and reliability.</p>
            </div>

            <div class="feature-item">
                <div class="feature-icon">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <h4 class="feature-title">Best Prices</h4>
                <p class="feature-desc">Competitive rates with transparent pricing—no hidden fees, guaranteed.</p>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <h3>50+</h3>
                <p>Vehicles Available</p>
            </div>
            <div class="stat-item">
                <h3>100%</h3>
                <p>GPS Enabled Fleet</p>
            </div>
            <div class="stat-item">
                <h3>5K+</h3>
                <p>Happy Customers</p>
            </div>
            <div class="stat-item">
                <h3>10+</h3>
                <p>Years Experience</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Ready to Hit the <span>Road?</span></h2>
            <p class="cta-desc">
                Join thousands of customers who trust NJ Car Rentals for their transportation needs. 
                Book your perfect ride today or explore our quality vehicle inventory.
            </p>
            <div class="cta-buttons">
                <a href="{{ route('vehicles.rental') }}" class="btn-primary">
                    <i class="bi bi-calendar-check"></i>Rent a Car
                </a>
                <a href="{{ route('vehicles.sale') }}" class="btn-secondary">
                    <i class="bi bi-bag-check"></i>Buy a Car
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Search handler
    function handleSearch(event) {
        event.preventDefault();

        const type = document.getElementById('vehicleType').value;
        const query = document.getElementById('searchQuery').value;
        const maxPrice = document.getElementById('maxPrice').value;

        let url = '@if(route('vehicles.index')){{ route('vehicles.index') }}@endif';
        
        @if(route('vehicles.rental'))
        if (type === 'rental') {
            url = '{{ route('vehicles.rental') }}';
        } 
        @endif
        @if(route('vehicles.sale'))
        else if (type === 'sale') {
            url = '{{ route('vehicles.sale') }}';
        }
        @endif

        const params = new URLSearchParams();
        if (query) params.append('q', query);
        if (maxPrice) params.append('max_price', maxPrice);

        const fullUrl = params.toString() ? url + '?' + params.toString() : url;
        window.location.href = fullUrl;
    }

    // Allow Enter key to search
    document.getElementById('searchQuery').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('searchForm').dispatchEvent(new Event('submit'));
        }
    });

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Animate stats counters
        const counters = document.querySelectorAll('.stat-item h3');
        counters.forEach(counter => {
            const text = counter.textContent.trim();
            const targetStr = text.replace(/[+,]/g, '');
            const target = parseInt(targetStr);
            
            if (!isNaN(target)) {
                let current = 0;
                const increment = target / 50;
                
                const updateCounter = () => {
                    if (current < target) {
                        current += increment;
                        counter.textContent = Math.ceil(current) + (text.includes('+') ? '+' : '');
                        setTimeout(updateCounter, 30);
                    } else {
                        counter.textContent = text;
                    }
                };
                
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            updateCounter();
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.5 });
                
                observer.observe(counter);
            }
        });

        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe featured cards for animation
        document.querySelectorAll('.featured-card, .feature-item').forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = `all 0.6s ease ${index * 0.1}s`;
            observer.observe(el);
        });
    });
</script>
@endsection

