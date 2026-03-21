@extends('layouts.app')

@section('title', 'Forgot Password')

@section('styles')
<style>
    .auth-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    }
    .auth-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 40px;
        max-width: 450px;
        width: 100%;
    }
    .auth-logo {
        text-align: center;
        margin-bottom: 30px;
    }
    .auth-logo i {
        font-size: 48px;
        color: #0d6efd;
    }
    .auth-logo h3 {
        color: white;
        margin-top: 10px;
        font-weight: 600;
    }
    .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 12px 16px;
        border-radius: 10px;
    }
    .form-control:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: #0d6efd;
        color: white;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
    }
    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }
    .form-label {
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
        margin-bottom: 8px;
    }
    .btn-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        width: 100%;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #0b5ed7 0%, #0953c9 100%);
    }
    .auth-links {
        text-align: center;
        margin-top: 20px;
    }
    .auth-links a {
        color: #0d6efd;
        text-decoration: none;
    }
    .auth-links a:hover {
        text-decoration: underline;
    }
    .back-to-login {
        text-align: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    .back-to-login a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
    }
    .back-to-login a:hover {
        color: white;
    }
    .info-box {
        background: rgba(13, 110, 253, 0.1);
        border: 1px solid rgba(13, 110, 253, 0.3);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
    }
    .info-box i {
        color: #0d6efd;
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-logo">
            <i class="bi bi-key-fill"></i>
            <h3>Forgot Password?</h3>
        </div>

        <div class="info-box">
            <i class="bi bi-info-circle"></i>
            Enter your email address and we'll send you a link to reset your password.
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="background: rgba(25, 135, 84, 0.2); border: 1px solid rgba(25, 135, 84, 0.5); color: #75b798;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" style="background: rgba(220, 53, 69, 0.2); border: 1px solid rgba(220, 53, 69, 0.5); color: #ea868f;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('customer.password.email') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus
                       placeholder="Enter your email address">
                @error('email')
                    <div class="invalid-feedback" style="color: #ea868f;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-2"></i>Send Reset Link
                </button>
            </div>
        </form>

        <div class="back-to-login">
            <a href="{{ route('customer.login') }}">
                <i class="bi bi-arrow-left me-1"></i> Back to Login
            </a>
        </div>
    </div>
</div>
@endsection

