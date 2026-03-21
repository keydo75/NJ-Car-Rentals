@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary-gradient text-white">
                    <h4 class="mb-0"><i class="bi bi-person-gear me-2"></i> Edit Profile</h4>
                </div>
                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Error!</strong> Please fix the following issues:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('customer.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                           id="first_name" name="first_name" value="{{ old('first_name', $customer->first_name) }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="middle_initial" class="form-label">M.I.</label>
                                    <input type="text" class="form-control @error('middle_initial') is-invalid @enderror"
                                           id="middle_initial" name="middle_initial" value="{{ old('middle_initial', $customer->middle_initial) }}" maxlength="5">
                                    @error('middle_initial')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                           id="last_name" name="last_name" value="{{ old('last_name', $customer->last_name) }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Current full name: <strong>{{ $customer->name }}</strong></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $customer->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone', $customer->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="loyalty_points" class="form-label">Loyalty Points</label>
                                <input type="number" class="form-control" id="loyalty_points"
                                       value="{{ $customer->loyalty_points }}" readonly>
                                <small class="form-text text-muted">Loyalty points cannot be edited manually.</small>
                            </div>
                        </div>

                        <div class="mb-3 address-section" data-init-address>
                            <label class="form-label">Complete Address</label>
                            
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Region</label>
                                    <select id="region" class="form-select" required>
                                        <option value="">Select Region</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Province</label>
                                    <select id="province" class="form-select" required disabled>
                                        <option value="">Select Province</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">City / Municipality</label>
                                    <select id="city" class="form-select" required disabled>
                                        <option value="">Select City / Municipality</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Barangay</label>
                                    <input type="text" class="form-control" id="barangay" placeholder="e.g. San Antonio">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label small text-muted mb-1">Street Address, House #, etc.</label>
                                    <input type="text" class="form-control" id="street" placeholder="e.g. 123 Maple St">
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
                            
                            <input type="hidden" name="address" id="address" data-prefill="{{ old('address', $customer->address) }}" value="{{ old('address', $customer->address) }}">
                            @error('address')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">Change Password (Optional)</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                           id="current_password" name="current_password">
                                    <button class="btn btn-outline-secondary password-toggle" type="button">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group">
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                           id="new_password" name="new_password" minlength="8">
                                    <button class="btn btn-outline-secondary password-toggle" type="button">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                   id="new_password_confirmation" name="new_password_confirmation">
                            @error('new_password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

@push('scripts')
<script src="{{ asset('js/ph-address-cascading.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle
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

    phAddress.initPhAddressCascading(document.querySelector('.address-section'));

    // Phone mask
    const phone = document.getElementById('phone');
    phone.addEventListener('input', function (e) {
        let val = e.target.value.replace(/\D/g, '');
        val = val.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
        e.target.value = val;
    });
});
</script>
@endpush
@endsection
