@extends('layouts.app')

@section('title', 'Admin Login')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<div class="container py-4">
    <div class="row align-items-center mb-5 hero">
        <div class="col-lg-6">
            <h1 class="display-2 fw-bold text-white">Admin Access</h1>
            <p class="lead text-muted mb-4">Sign in to manage the site, view analytics, and handle vehicle and transaction workflows.</p>
            <div class="d-flex gap-3 mt-4">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg product-cta">Dashboard</a>
                <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg product-cta">Visit Site</a>
            </div>
        </div>

        <div class="col-lg-6 d-flex justify-content-center">
            <div class="card bg-dark text-white shadow-lg mx-auto" style="max-width:420px; width:100%;">
                <div class="card-body p-4">
                    <h3 class="card-title mb-3 text-center">Admin Login</h3>

                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label small">Email address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label small">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-accent btn-lg">Login as Admin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection