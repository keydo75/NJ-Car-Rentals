@extends('layouts.app')

@section('title', 'Customer Registration')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<div class="container py-4">
    <div class="row align-items-center mb-5 hero">
        <div class="col-lg-6">
            <h1 class="display-2 fw-bold text-white">Create Your Account</h1>
            <p class="lead text-muted mb-4">Join NJ Car Rentals today and get access to our premium vehicles, exclusive deals, and seamless booking experience.</p>
            <div class="d-flex gap-3 mt-4">
                <a href="{{ route('vehicles.rental') }}" class="btn btn-primary btn-lg product-cta">Browse Vehicles</a>
                <a href="{{ route('customer.login') }}" class="btn btn-outline-primary btn-lg product-cta">Already Registered?</a>
            </div>
        </div>
        
        <div class="col-lg-6 d-flex justify-content-center">
            <div style="max-width:520px; width:100%;">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary-gradient text-white text-center py-3">
                        <h3 class="mb-0"><i class="bi bi-person-plus me-2"></i> Customer Registration</h3>
                        <p class="mb-0">Create your NJ Car Rentals account</p>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><i class="bi bi-exclamation-circle me-2"></i> Registration Failed</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('customer.register.submit') }}" novalidate>
                            @csrf
                            
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="first_name" class="form-label">First Name *</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           id="first_name" name="first_name" value="{{ old('first_name') }}" required autofocus
                                           placeholder="First name">
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label for="middle_initial" class="form-label">M.I.</label>
                                    <input type="text" class="form-control @error('middle_initial') is-invalid @enderror" 
                                           id="middle_initial" name="middle_initial" value="{{ old('middle_initial') }}"
                                           placeholder="M." maxlength="5">
                                    @error('middle_initial')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           id="last_name" name="last_name" value="{{ old('last_name') }}" required
                                           placeholder="Last name">
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required
                                       placeholder="Enter your email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required
                                           placeholder="Create a password">
                                            <button class="btn btn-outline-secondary password-toggle" type="button">
                                                <i class="bi bi-eye-slash"></i>
                                            </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div id="pw-strength" class="mt-1 small"></div>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm Password *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           id="password_confirmation" name="password_confirmation" required
                                           placeholder="Confirm password">
                                    <button class="btn btn-outline-secondary password-toggle" type="button">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="form-label">Phone Number *</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}" required
                                       placeholder="Enter your phone number">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-4 address-section">
                                <label class="form-label">Complete Address <span class="text-danger">*</span></label>
                                
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">Region *</label>
                                        <select id="region" class="form-select @error('region') is-invalid @enderror" required>
                                            <option value="">Select Region</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">Province *</label>
                                        <select id="province" class="form-select @error('province') is-invalid @enderror" required disabled>
                                            <option value="">Select Province</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">City / Municipality *</label>
                                        <select id="city" class="form-select @error('city') is-invalid @enderror" required disabled>
                                            <option value="">Select City / Municipality</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">Barangay *</label>
                                        <input type="text" class="form-control @error('barangay') is-invalid @enderror" 
                                               id="barangay" name="barangay" placeholder="e.g. San Antonio" required>
                                        @error('barangay')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label small text-muted mb-1">Street Address, House #, etc. *</label>
                                        <input type="text" class="form-control @error('street') is-invalid @enderror" 
                                               id="street" name="street" placeholder="e.g. 123 Maple St, Brgy San Antonio" required>
                                        @error('street')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div id="address-preview" class="form-text bg-light p-2 rounded border">Address will appear here...</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="address-status" class="form-text small">Address completeness: 0%</div>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="address" id="address" value="{{ old('address') }}" required>
                                @error('address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#termsModal">Terms & Conditions</a> and <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#cancellationModal">Cancellation Policy</a> <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-person-check me-2"></i> Create Account
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="mb-0">Already have an account? 
                                    <a href="{{ route('customer.login') }}" class="text-primary fw-semibold">Sign In</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/ph-address-cascading.js') }}"></script>
<script>

document.addEventListener('DOMContentLoaded', function() {
    // Password toggle - starts as "hide" (eye-slash), shows on click
    document.querySelectorAll('.password-toggle').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('input');
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    });

    // Professional PH Address - Using shared module
        phAddress.initPhAddressCascading(document.querySelector('.address-section'));

    // Password strength
    const pw = document.getElementById('password');
    const strength = document.getElementById('pw-strength') || document.createElement('div');
    if (strength.id !== 'pw-strength') {
        strength.id = 'pw-strength';
        strength.className = 'mt-1 small';
        pw.parentNode.appendChild(strength);
    }
    pw.addEventListener('input', function() {
        const val = this.value;
        const hasUpper = /[A-Z]/.test(val);
        const hasLower = /[a-z]/.test(val);
        const hasDigit = /\d/.test(val);
        const hasSpecial = /[!@#$%^&*]/.test(val);
        const length = val.length >= 8;
        const score = (hasUpper + hasLower + hasDigit + hasSpecial + length);
        strength.textContent = score >= 4 ? 'Strong' : score >= 3 ? 'Medium' : 'Weak';
        strength.className = `mt-1 small ${score >= 4 ? 'text-success' : score >= 3 ? 'text-warning' : 'text-danger'}`;
    });

    // Phone mask
    const phone = document.getElementById('phone');
    phone.addEventListener('input', function (e) {
        let val = e.target.value.replace(/\D/g, '');
        if (val.length >= 10) val = val.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
        else if (val.length >= 7) val = val.replace(/(\d{3})(\d{4})/, '($1) $2');
        e.target.value = val;
    });
});
</script>
@endpush


