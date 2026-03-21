@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<!-- Hero Section -->
<div class="hero-section" style="min-height: 40vh; padding: 100px 0 60px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <div class="hero-badge" style="display: inline-flex; margin-bottom: 20px;">
                        <i class="bi bi-chat-dots me-2"></i>Get in Touch
                    </div>
                    <h1 class="hero-title" style="font-size: 3rem;">Contact <span>Us</span></h1>
                    <p class="hero-subtitle" style="max-width: 600px; margin: 0 auto;">
                        Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Section -->
<div class="py-5" style="background: #0a0f1a;">
    <div class="container">
        <div class="row">
            <!-- Contact Info -->
            <div class="col-lg-4 mb-4">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; height: 100%;">
                    <div class="card-body p-4">
                        <h4 style="font-family: 'Playfair Display', serif; color: #fff; margin-bottom: 24px;">Contact Information</h4>
                        
                        <div class="contact-item d-flex align-items-start mb-4">
                            <div class="contact-icon" style="min-width: 50px;">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <h6 style="color: #fff; margin-bottom: 4px;">Location</h6>
                                <p style="color: #8892a0; margin: 0; font-size: 0.9rem;">Mabayuan Olongapo City, Philippines 2200</p>
                            </div>
                        </div>

                        <div class="contact-item d-flex align-items-start mb-4">
                            <div class="contact-icon" style="min-width: 50px;">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div>
                                <h6 style="color: #fff; margin-bottom: 4px;">Phone</h6>
                                <p style="color: #8892a0; margin: 0; font-size: 0.9rem;">+63 999 123 4567</p>
                            </div>
                        </div>

                        <div class="contact-item d-flex align-items-start mb-4">
                            <div class="contact-icon" style="min-width: 50px;">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <h6 style="color: #fff; margin-bottom: 4px;">Email</h6>
                                <p style="color: #8892a0; margin: 0; font-size: 0.9rem;">contact@njcarrentals.com</p>
                            </div>
                        </div>

                        <div class="contact-item d-flex align-items-start mb-4">
                            <div class="contact-icon" style="min-width: 50px;">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div>
                                <h6 style="color: #fff; margin-bottom: 4px;">Business Hours</h6>
                                <p style="color: #8892a0; margin: 0; font-size: 0.9rem;">Mon - Sat: 8:00 AM - 6:00 PM<br>Sunday: 9:00 AM - 2:00 PM</p>
                            </div>
                        </div>

                        <hr style="border-color: #1d3557; margin: 24px 0;">

                        <h6 style="color: #fff; margin-bottom: 16px;">Follow Us</h6>
                        <div class="d-flex gap-3">
                            <a href="#" class="social-link" style="width: 40px; height: 40px; background: #1d3557; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #8892a0; transition: all 0.3s ease;">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="social-link" style="width: 40px; height: 40px; background: #1d3557; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #8892a0; transition: all 0.3s ease;">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="social-link" style="width: 40px; height: 40px; background: #1d3557; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #8892a0; transition: all 0.3s ease;">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="#" class="social-link" style="width: 40px; height: 40px; background: #1d3557; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #8892a0; transition: all 0.3s ease;">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="card" style="background: #112240; border: 1px solid #1d3557;">
                    <div class="card-body p-4">
                        <h4 style="font-family: 'Playfair Display', serif; color: #fff; margin-bottom: 24px;">Send us a Message</h4>
                        
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" placeholder="Enter your name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control" placeholder="Enter your email" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" placeholder="Enter your phone">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Subject</label>
                                    <select class="form-select">
                                        <option value="">Select a subject</option>
                                        <option value="rental">Car Rental Inquiry</option>
                                        <option value="sale">Car Purchase Inquiry</option>
                                        <option value="support">Customer Support</option>
                                        <option value="feedback">Feedback</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control" rows="6" placeholder="How can we help you?" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Map Section -->
<div style="background: #0a0f1a; padding-bottom: 80px;">
    <div class="container">
        <div class="card" style="background: #112240; border: 1px solid #1d3557;">
            <div class="card-body p-0">
                <div style="height: 350px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #0a192f, #112240);">
                    <div class="text-center">
                        <i class="bi bi-map" style="font-size: 4rem; color: #d4af37; opacity: 0.5; margin-bottom: 16px; display: block;"></i>
                        <p style="color: #8892a0; margin: 0;">Map integration available</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .contact-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #d4af37, #b8962e);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0a192f;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .social-link:hover {
        background: linear-gradient(135deg, #d4af37, #b8962e) !important;
        color: #0a192f !important;
        transform: translateY(-3px);
    }

    .form-label {
        color: #d4af37;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        background: #0a192f;
        border: 2px solid #1d3557;
        border-radius: 12px;
        padding: 14px 16px;
        color: #e8e8e8;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        background: #112240;
        border-color: #d4af37;
        box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.15);
        color: #fff;
    }

    .form-control::placeholder {
        color: #5a6a7a;
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

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.25rem;
        }
    }
</style>
@endsection

