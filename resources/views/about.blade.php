@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<!-- Hero Section -->
<div class="hero-section" style="min-height: 40vh; padding: 100px 0 60px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <div class="hero-badge" style="display: inline-flex; margin-bottom: 20px;">
                        <i class="bi bi-info-circle me-2"></i>Our Story
                    </div>
                    <h1 class="hero-title" style="font-size: 3rem;">About <span>Us</span></h1>
                    <p class="hero-subtitle" style="max-width: 600px; margin: 0 auto;">
                        Learn more about NJ Car Rentals and our commitment to providing exceptional service.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About Section -->
<div class="py-5" style="background: #0a0f1a;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4">
                <h2 style="font-family: 'Playfair Display', serif; color: #fff; font-size: 2.25rem; margin-bottom: 20px;">
                    Premium Car Rental & Sales Services
                </h2>
                <p style="color: #8892a0; line-height: 1.8; margin-bottom: 20px;">
                    NJ Car Rentals is your trusted partner for premium car rental and buy-and-sell services in Olongapo City and surrounding areas. We pride ourselves on offering well-maintained vehicles, transparent pricing, and exceptional customer service.
                </p>
                <p style="color: #8892a0; line-height: 1.8; margin-bottom: 20px;">
                    Since our inception, we have been committed to providing our customers with safe, reliable, and comfortable transportation solutions. Our fleet is equipped with modern GPS tracking technology, ensuring peace of mind for every journey.
                </p>
                <div class="d-flex gap-4 mt-4">
                    <div>
                        <h3 style="font-family: 'Playfair Display', serif; color: #d4af37; font-size: 2rem; margin: 0;">50+</h3>
                        <small style="color: #8892a0;">Vehicles</small>
                    </div>
                    <div>
                        <h3 style="font-family: 'Playfair Display', serif; color: #d4af37; font-size: 2rem; margin: 0;">5K+</h3>
                        <small style="color: #8892a0;">Customers</small>
                    </div>
                    <div>
                        <h3 style="font-family: 'Playfair Display', serif; color: #d4af37; font-size: 2rem; margin: 0;">10+</h3>
                        <small style="color: #8892a0;">Years</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 20px; overflow: hidden;">
                    <div style="height: 300px; background: linear-gradient(135deg, #0a192f, #112240); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-car-front-fill" style="font-size: 8rem; color: #d4af37; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mission & Vision -->
<div class="py-5" style="background: linear-gradient(180deg, #0a0f1a 0%, #0d1424 100%);">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 20px; padding: 40px; height: 100%;">
                    <div class="feature-icon" style="width: 60px; height: 60px; margin-bottom: 20px;">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <h3 style="font-family: 'Playfair Display', serif; color: #fff; margin-bottom: 16px;">Our Mission</h3>
                    <p style="color: #8892a0; line-height: 1.8;">
                        To provide reliable, safe, and convenient car rental and sales services with the integration of modern GPS tracking technology for enhanced customer experience and security. We strive to exceed expectations in every interaction.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 20px; padding: 40px; height: 100%;">
                    <div class="feature-icon" style="width: 60px; height: 60px; margin-bottom: 20px;">
                        <i class="bi bi-eye"></i>
                    </div>
                    <h3 style="font-family: 'Playfair Display', serif; color: #fff; margin-bottom: 16px;">Our Vision</h3>
                    <p style="color: #8892a0; line-height: 1.8;">
                        To become the leading car rental and sales service provider in Central Luzon through digital innovation and exceptional customer service. We envision a future where everyone has access to quality transportation.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Values -->
<div class="py-5" style="background: #0a0f1a;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our <span>Values</span></h2>
            <p class="section-subtitle">The principles that guide everything we do</p>
        </div>

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="feature-item" style="text-align: center; padding: 30px 20px; height: 100%;">
                    <div class="feature-icon" style="width: 60px; height: 60px; margin: 0 auto 16px;">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h5 style="color: #fff; margin-bottom: 8px;">Trust & Safety</h5>
                    <p style="color: #8892a0; font-size: 0.9rem; margin: 0;">Your safety is our top priority with GPS tracking on all vehicles</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-item" style="text-align: center; padding: 30px 20px; height: 100%;">
                    <div class="feature-icon" style="width: 60px; height: 60px; margin: 0 auto 16px;">
                        <i class="bi bi-hand-thumbs-up"></i>
                    </div>
                    <h5 style="color: #fff; margin-bottom: 8px;">Quality Service</h5>
                    <p style="color: #8892a0; font-size: 0.9rem; margin: 0;">Well-maintained vehicles for a smooth driving experience</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-item" style="text-align: center; padding: 30px 20px; height: 100%;">
                    <div class="feature-icon" style="width: 60px; height: 60px; margin: 0 auto 16px;">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <h5 style="color: #fff; margin-bottom: 8px;">Transparent Pricing</h5>
                    <p style="color: #8892a0; font-size: 0.9rem; margin: 0;">No hidden fees - what you see is what you pay</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-item" style="text-align: center; padding: 30px 20px; height: 100%;">
                    <div class="feature-icon" style="width: 60px; height: 60px; margin: 0 auto 16px;">
                        <i class="bi bi-people"></i>
                    </div>
                    <h5 style="color: #fff; margin-bottom: 8px;">Customer First</h5>
                    <p style="color: #8892a0; font-size: 0.9rem; margin: 0;">24/7 support to assist you anytime</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Team Section -->
<div class="py-5" style="background: linear-gradient(180deg, #0a0f1a 0%, #0d1424 100%);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Meet the <span>Team</span></h2>
            <p class="section-subtitle">The people behind NJ Car Rentals</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-3 col-6 mb-4">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 20px; text-align: center; padding: 30px;">
                    <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #d4af37, #b8962e); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <i class="bi bi-person" style="font-size: 2.5rem; color: #0a192f;"></i>
                    </div>
                    <h5 style="color: #fff; margin-bottom: 4px;">Ebalo, Sean Terell</h5>
                    <small style="color: #d4af37;">Project Lead</small>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 20px; text-align: center; padding: 30px;">
                    <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #0ea5e9, #0284c7); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <i class="bi bi-person" style="font-size: 2.5rem; color: #fff;"></i>
                    </div>
                    <h5 style="color: #fff; margin-bottom: 4px;">Jabagat, Ken</h5>
                    <small style="color: #0ea5e9;">Backend Developer</small>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 20px; text-align: center; padding: 30px;">
                    <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <i class="bi bi-person" style="font-size: 2.5rem; color: #fff;"></i>
                    </div>
                    <h5 style="color: #fff; margin-bottom: 4px;">Pamintuan, Mayverick</h5>
                    <small style="color: #10b981;">Frontend Developer</small>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 20px; text-align: center; padding: 30px;">
                    <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <i class="bi bi-person" style="font-size: 2.5rem; color: #fff;"></i>
                    </div>
                    <h5 style="color: #fff; margin-bottom: 4px;">Pintucan, Marvie Christian</h5>
                    <small style="color: #f59e0b;">Database Admin</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tech Stack -->
<div class="py-5" style="background: #0a0f1a;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Technology <span>Stack</span></h2>
            <p class="section-subtitle">Modern tools powering our platform</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-2 col-4 mb-4">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 16px; text-align: center; padding: 20px;">
                    <i class="bi bi-code-slash" style="font-size: 2rem; color: #d4af37; margin-bottom: 10px;"></i>
                    <h6 style="color: #fff; margin: 0;">Laravel</h6>
                </div>
            </div>
            <div class="col-md-2 col-4 mb-4">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 16px; text-align: center; padding: 20px;">
                    <i class="bi bi-database" style="font-size: 2rem; color: #d4af37; margin-bottom: 10px;"></i>
                    <h6 style="color: #fff; margin: 0;">MySQL</h6>
                </div>
            </div>
            <div class="col-md-2 col-4 mb-4">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 16px; text-align: center; padding: 20px;">
                    <i class="bi bi-bootstrap" style="font-size: 2rem; color: #d4af37; margin-bottom: 10px;"></i>
                    <h6 style="color: #fff; margin: 0;">Bootstrap 5</h6>
                </div>
            </div>
            <div class="col-md-2 col-4 mb-4">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 16px; text-align: center; padding: 20px;">
                    <i class="bi bi-geo-alt" style="font-size: 2rem; color: #d4af37; margin-bottom: 10px;"></i>
                    <h6 style="color: #fff; margin: 0;">GPS API</h6>
                </div>
            </div>
            <div class="col-md-2 col-4 mb-4">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 16px; text-align: center; padding: 20px;">
                    <i class="bi bi-server" style="font-size: 2rem; color: #d4af37; margin-bottom: 10px;"></i>
                    <h6 style="color: #fff; margin: 0;">REST API</h6>
                </div>
            </div>
            <div class="col-md-2 col-4 mb-4">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 16px; text-align: center; padding: 20px;">
                    <i class="bi bi-shield-check" style="font-size: 2rem; color: #d4af37; margin-bottom: 10px;"></i>
                    <h6 style="color: #fff; margin: 0;">Security</h6>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
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
    }

    .hero-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 3rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 16px;
    }

    .hero-title span {
        background: linear-gradient(135deg, #d4af37, #e9c95d);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-subtitle {
        font-size: 1.1rem;
        color: #8892a0;
    }

    .section-header {
        text-align: center;
        margin-bottom: 48px;
    }

    .section-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.25rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 12px;
    }

    .section-title span {
        background: linear-gradient(135deg, #d4af37, #e9c95d);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .section-subtitle {
        font-size: 1.1rem;
        color: #6c757d;
    }

    .feature-item {
        background: #112240;
        border: 1px solid #1d3557;
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        border-color: #d4af37;
        transform: translateY(-5px);
    }

    .feature-icon {
        background: linear-gradient(135deg, #d4af37, #b8962e);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0a192f;
        font-size: 1.5rem;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.25rem;
        }
    }
</style>
@endsection

