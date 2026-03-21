@extends('layouts.app')

@section('title', 'Reset Password')

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
    .password-strength {
        margin-top: 8px;
    }
    .password-strength .progress {
        height: 6px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
    }
    .password-strength .progress-bar {
        border-radius: 3px;
    }
    .password-requirements {
        margin-top: 15px;
        padding: 12px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
    }
    .password-requirements p {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.85rem;
        margin-bottom: 5px;
    }
    .password-requirements ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .password-requirements li {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.8rem;
        margin-bottom: 3px;
    }
    .password-requirements li i {
        margin-right: 5px;
    }
    .password-requirements li.valid {
        color: #75b798;
    }
    .password-requirements li.valid i {
        color: #75b798;
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-logo">
            <i class="bi bi-shield-lock-fill"></i>
            <h3>Reset Password</h3>
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

        <form method="POST" action="{{ route('customer.password.update') }}">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
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

            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       required
                       placeholder="Enter new password">
                @error('password')
                    <div class="invalid-feedback" style="color: #ea868f;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" 
                       class="form-control" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       required
                       placeholder="Confirm new password">
            </div>

            <div class="password-requirements">
                <p><i class="bi bi-info-circle"></i> Password requirements:</p>
                <ul>
                    <li id="req-length"><i class="bi bi-circle"></i> At least 8 characters</li>
                    <li id="req-match"><i class="bi bi-circle"></i> Passwords match</li>
                </ul>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check2-circle me-2"></i>Reset Password
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const reqLength = document.getElementById('req-length');
    const reqMatch = document.getElementById('req-match');

    function checkPassword() {
        // Check length
        if (password.value.length >= 8) {
            reqLength.classList.add('valid');
            reqLength.querySelector('i').classList.remove('bi-circle');
            reqLength.querySelector('i').classList.add('bi-check-circle-fill');
        } else {
            reqLength.classList.remove('valid');
            reqLength.querySelector('i').classList.remove('bi-check-circle-fill');
            reqLength.querySelector('i').classList.add('bi-circle');
        }

        // Check match
        if (password.value === passwordConfirmation.value && password.value !== '') {
            reqMatch.classList.add('valid');
            reqMatch.querySelector('i').classList.remove('bi-circle');
            reqMatch.querySelector('i').classList.add('bi-check-circle-fill');
        } else {
            reqMatch.classList.remove('valid');
            reqMatch.querySelector('i').classList.remove('bi-check-circle-fill');
            reqMatch.querySelector('i').classList.add('bi-circle');
        }
    }

    password.addEventListener('input', checkPassword);
    passwordConfirmation.addEventListener('input', checkPassword);
});
</script>
@endsection

