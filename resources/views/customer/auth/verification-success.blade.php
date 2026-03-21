@extends('layouts.app')

@section('title', 'Email Verified - NJ Car Rentals')

@section('content')
<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5">
            <div class="text-center">
                <!-- Success Icon -->
                <div class="mb-4">
                    <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 10px 40px rgba(16, 185, 129, 0.3);">
                        <i class="bi bi-check-lg text-white" style="font-size: 50px;"></i>
                    </div>
                </div>

                <h2 class="mb-3" style="color: #1a1a2e;">Email Verified Successfully!</h2>
                
                <p class="text-muted mb-4">
                    Congratulations! Your email address has been verified. You can now log in to your NJ Car Rentals account and start booking vehicles.
                </p>

                <div class="d-grid gap-2">
                    <a href="{{ route('customer.login') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Login Now
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-house me-2"></i> Back to Home
                    </a>
                </div>

                <!-- Features Highlight -->
                <div class="mt-5 p-4 bg-light rounded-3">
                    <h5 class="mb-3">What's Next?</h5>
                    <div class="text-start">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                <i class="bi bi-car-front text-primary"></i>
                            </div>
                            <div>
                                <strong>Browse Vehicles</strong>
                                <p class="mb-0 small text-muted">Explore our wide range of cars for rent</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                <i class="bi bi-calendar-check text-primary"></i>
                            </div>
                            <div>
                                <strong>Make a Booking</strong>
                                <p class="mb-0 small text-muted">Reserve your preferred vehicle instantly</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                <i class="bi bi-gift text-primary"></i>
                            </div>
                            <div>
                                <strong>Earn Rewards</strong>
                                <p class="mb-0 small text-muted">Get loyalty points with every rental</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

