@extends('layouts.app')

@section('title', 'Customer Login')

@section('content')
<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5">
            <div class="card bg-dark text-white shadow-lg mx-auto">
                <div class="card-body p-4">
                    <h3 class="card-title mb-3 text-center">Customer Login</h3>

                    @if ($errors->any())
                        <div class="alert alert-danger text-white">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success text-dark">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    <!-- Verification Pending Alert -->
                    @if (session('verification_pending'))
                        <div class="alert alert-warning text-dark">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-envelope-exclamation-fill me-2 mt-1"></i>
                                <div>
                                    <strong>Email Verification Required</strong>
                                    <p class="mb-2 small">Please verify your email address before logging in. Check your inbox (and spam folder) for the verification link.</p>
                                    <form method="POST" action="{{ route('customer.verification.resend') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ session('resend_email') }}">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-arrow-repeat me-1"></i> Resend Verification Email
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('customer.login') }}" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label small">Email address</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label small">Password</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small" for="remember">Remember me</label>
                            </div>
                            <a href="{{ route('customer.password.request') }}" class="small text-decoration-none text-muted">Forgot password?</a>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-accent btn-lg">Sign in</button>
                        </div>
                    </form>

                    <hr class="my-4 border-secondary">
                    
                    <div class="text-center">
                        <p class="mb-2 small text-muted">Don't have an account?</p>
                        <a href="{{ route('customer.register') }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-person-plus me-1"></i> Create Account
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Card styling for central layout */
    .card.bg-dark {
        border: 1px solid rgba(255,255,255,0.04);
        background: rgba(255,255,255,0.02);
        border-radius: .75rem;
        box-shadow: 0 8px 30px rgba(7,7,7,0.6);
    }

    .card-title { font-weight:700; font-size:1.4rem; }

    /* Form controls - larger, rounded, and focus ring matching brand */
    .form-control {
        border-radius: .5rem;
        padding: .9rem 1rem;
        background: #fff;
        border: 1px solid rgba(0,0,0,0.08);
        color: #000;
        font-weight: 500;
    }
    .form-control::placeholder {
        color: #999;
    }
    .form-control:focus {
        box-shadow: 0 0 0 .2rem rgba(13,110,253,0.15);
        border-color: #0d6efd;
        outline: none;
        color: #000;
    }

    /* Accent button (page-specific: black sign-in) */
    .btn-accent {
        background-color: #000;
        border-color: #000;
        color: #fff;
        border-radius: .75rem;
        padding: .75rem 1.25rem;
        font-size: 1.125rem;
        box-shadow: 0 6px 18px rgba(0,0,0,0.25);
    }
    .btn-accent:hover {
        background-color: #111;
        border-color: #111;
        box-shadow: 0 10px 28px rgba(0,0,0,0.32);
    }
    .btn-accent:focus-visible {
        outline: 3px solid rgba(255,255,255,0.12);
        outline-offset: 2px;
    }

    .btn-outline-light { border-radius: .75rem; }
    .small.text-muted { color: #9aa6b2!important; }

    /* Ensure full-height center alignment on small screens */
    .min-vh-100 { min-height: 100vh; }

    /* Show password button styling */
    .input-group .btn-outline-secondary {
        border-color: rgba(0,0,0,0.08);
        color: #666;
    }
    .input-group .btn-outline-secondary:hover {
        color: #000;
        background-color: #f0f0f0;
    }

    /* Alert styling */
    .alert {
        border-radius: .5rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', function() {
            const icon = toggleBtn.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    }
});
</script>
@endsection
