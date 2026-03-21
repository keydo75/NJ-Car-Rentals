@extends('layouts.app')

@section('title', 'Register')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
    .auth-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #050a12 0%, #0a192f 50%, #112240 100%);
        position: relative;
        overflow: hidden;
        padding: 40px 0;
    }

    .auth-page::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(ellipse at 20% 80%, rgba(212, 175, 55, 0.08) 0%, transparent 50%),
            radial-gradient(ellipse at 80% 20%, rgba(212, 175, 55, 0.05) 0%, transparent 40%);
        pointer-events: none;
    }

    .auth-page::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 50%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d4af37' fill-opacity='0.03'%3E%3Cpath d='M50 50v-10H40v10h-10v10h10v10h10v-10h10v-10h-10zm0-30V10h-10v10h-10v10h10v10h10V20h10V10h-10zM10 50v-10H0v10h-10v10h10v10h10v-10h10v-10H10zM10 10V0H0v10h-10v10h10V10h10V0H10z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.5;
        pointer-events: none;
    }

    .auth-container {
        position: relative;
        z-index: 1;
        width: 100%;
        padding: 20px;
    }

    .auth-card {
        background: rgba(17, 34, 64, 0.8);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        overflow: hidden;
        max-width: 1000px;
        margin: 0 auto;
    }

    .auth-card-header {
        background: linear-gradient(135deg, #0a192f 0%, #112240 100%);
        padding: 40px;
        text-align: center;
        border-bottom: 1px solid rgba(212, 175, 55, 0.2);
    }

    .auth-card-header h3 {
        font-family: 'Playfair Display', Georgia, serif;
        color: #fff;
        font-size: 1.75rem;
        margin-bottom: 8px;
    }

    .auth-card-header p {
        color: #8892a0;
        margin: 0;
    }

    .auth-card-body {
        padding: 40px;
    }

    .auth-form .form-label {
        color: #d4af37;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .auth-form .form-control {
        background: #0a192f;
        border: 2px solid #1d3557;
        border-radius: 12px;
        padding: 14px 16px;
        color: #e8e8e8;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .auth-form .form-control:focus {
        background: #112240;
        border-color: #d4af37;
        box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.15);
        color: #fff;
    }

    .auth-form .form-control::placeholder {
        color: #5a6a7a;
    }

    .auth-form .form-control.is-invalid {
        border-color: #ef4444;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 6px;
    }

    .password-toggle {
        background: #1d3557;
        border: 2px solid #1d3557;
        border-left: none;
        color: #8892a0;
        transition: all 0.3s ease;
    }

    .password-toggle:hover {
        background: #112240;
        border-color: #d4af37;
        color: #d4af37;
    }

    .terms-checkbox .form-check-input {
        background-color: #0a192f;
        border-color: #1d3557;
    }

    .terms-checkbox .form-check-input:checked {
        background-color: #d4af37;
        border-color: #d4af37;
    }

    .terms-checkbox .form-check-input:focus {
        box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.15);
    }

    .terms-checkbox .form-check-label {
        color: #8892a0;
    }

    .terms-checkbox .form-check-label a {
        color: #d4af37;
    }

    .auth-btn {
        padding: 14px 32px;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 12px;
    }

    .login-link {
        text-align: center;
        margin-top: 24px;
        color: #8892a0;
    }

    .login-link a {
        color: #d4af37;
        font-weight: 600;
    }

    /* Left side content */
    .auth-content {
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .auth-content h1 {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 16px;
    }

    .auth-content h1 span {
        background: linear-gradient(135deg, #d4af37, #e9c95d);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .auth-content p {
        color: #8892a0;
        margin-bottom: 32px;
        line-height: 1.7;
    }

    .auth-benefits {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .auth-benefit {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #a0aec0;
    }

    .auth-benefit i {
        width: 36px;
        height: 36px;
        background: rgba(212, 175, 55, 0.1);
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d4af37;
    }

    .auth-benefit span {
        font-size: 0.95rem;
    }

    .form-text {
        color: #6c757d;
        font-size: 0.85rem;
        margin-top: 6px;
    }

    @media (max-width: 768px) {
        .auth-card {
            max-width: 100%;
        }

        .auth-content {
            display: none;
        }

        .auth-card-body {
            padding: 30px 20px;
        }

        .auth-card-header {
            padding: 30px 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="auth-card">
                    <div class="row g-0">
                        <!-- Left Side - Content -->
                        <div class="col-lg-5 d-none d-lg-block">
                            <div class="auth-content" style="height: 100%; background: linear-gradient(135deg, rgba(10, 25, 47, 0.9), rgba(17, 34, 64, 0.9));">
                                <h1>Join <span>Us</span></h1>
                                <p>Create your NJ Car Rentals account and unlock exclusive benefits, easy booking, and personalized service.</p>
                                
                                <div class="auth-benefits">
                                    <div class="auth-benefit">
                                        <i class="bi bi-car-front"></i>
                                        <span>Easy Booking</span>
                                    </div>
                                    <div class="auth-benefit">
                                        <i class="bi bi-gift"></i>
                                        <span>Exclusive Offers</span>
                                    </div>
                                    <div class="auth-benefit">
                                        <i class="bi bi-shield-check"></i>
                                        <span>Secure Account</span>
                                    </div>
                                    <div class="auth-benefit">
                                        <i class="bi bi-geo-alt"></i>
                                        <span>GPS Tracking</span>
                                    </div>
                                    <div class="auth-benefit">
                                        <i class="bi bi-headset"></i>
                                        <span>24/7 Support</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side - Register Form -->
                        <div class="col-lg-7">
                            <div class="auth-card-header">
                                <h3><i class="bi bi-person-plus me-2"></i>Create Account</h3>
                                <p>Fill in your details to get started</p>
                            </div>
                            <div class="auth-card-body">
                                <form method="POST" action="{{ route('register') }}" class="auth-form">
                                    @csrf
                                    
                                    <div class="mb-4">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name') }}" required 
                                               placeholder="Enter your full name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email') }}" required 
                                               placeholder="Enter your email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone') }}" required 
                                               placeholder="Enter your phone number">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" required 
                                                   placeholder="Create a password">
                                            <button class="btn password-toggle" type="button" id="togglePassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text">Password must be at least 8 characters long.</small>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation" required 
                                                   placeholder="Confirm your password">
                                            <button class="btn password-toggle" type="button" id="togglePasswordConfirm">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="form-check terms-checkbox">
                                            <input class="form-check-input" type="checkbox" id="terms" required>
                                            <label class="form-check-label" for="terms">
                                                I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="d-grid mb-4">
                                        <button type="submit" class="btn btn-primary auth-btn">
                                            <i class="bi bi-person-plus me-2"></i>Create Account
                                        </button>
                                    </div>

                                    <div class="login-link">
                                        Already have an account? 
                                        <a href="{{ route('login') }}">Sign in</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Password visibility toggle
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            if (type === 'text') {
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    }

    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    
    if (togglePasswordConfirm && passwordConfirmInput) {
        togglePasswordConfirm.addEventListener('click', function() {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            if (type === 'text') {
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    }
</script>
@endsection

