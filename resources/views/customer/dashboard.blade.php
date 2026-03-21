@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
<div class="container py-5">
    {{-- In-app notifications: show unread notifications as toasts and mark them read --}}
    @if(isset($customer) && $customer->unreadNotifications->count())
        @foreach($customer->unreadNotifications as $notification)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    if (window.showToast) {
                        window.showToast(@json($notification->data['message'] ?? 'You have a new notification'), 'info');
                    }
                });
            </script>
            @php $notification->markAsRead(); @endphp
        @endforeach
    @endif
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="display-5 fw-bold text-white mb-2">Welcome, {{ $customer->name }}!</h1>
                    <p class="lead text-muted">Manage your bookings, rentals, and account settings.</p>
                </div>

            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-5">
        <!-- Account Info Card -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-header bg-primary-gradient text-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i> Account Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Full Name</label>
                        <p class="h6 mb-0">{{ $customer->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Email Address</label>
                        <p class="h6 mb-0">{{ $customer->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Phone Number</label>
                        <p class="h6 mb-0">{{ $customer->phone }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Address</label>
                        <p class="h6 mb-0">{{ $customer->address }}</p>
                    </div>

                </div>
            </div>
        </div>

        <!-- Loyalty Points Card -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-gift me-2"></i> Loyalty Points</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <h1 class="display-4 fw-bold text-success">{{ $customer->loyalty_points }}</h1>
                        <p class="text-muted">Points Available</p>
                    </div>
                    <p class="small text-muted mb-0">Earn points on every rental and use them for discounts!</p>
                </div>
            </div>
        </div>

        <!-- Member Since Card -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i> Member Since</h5>
                </div>
                <div class="card-body text-center">
                    <p class="h3 fw-bold mb-3">{{ $customer->created_at->format('M d, Y') }}</p>
                    <p class="text-muted small">Account Age: {{ $customer->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-12 mb-5">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary-gradient text-white">
                    <h5 class="mb-0"><i class="bi bi-lightning me-2"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('vehicles.rental') }}" class="btn btn-primary btn-lg w-100 py-3">
                                <i class="bi bi-car-front me-2 fs-5"></i>
                                <div>Browse Rentals</div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('vehicles.sale') }}" class="btn btn-info btn-lg w-100 py-3">
                                <i class="bi bi-tag me-2 fs-5"></i>
                                <div>Browse for Sale</div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('customer.bookings') }}" class="btn btn-warning btn-lg w-100 py-3">
                                <i class="bi bi-calendar-heart me-2 fs-5"></i>
                                <div>My Bookings</div>
                            </a>
                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State for Bookings -->
        <div class="col-lg-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary-gradient text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i> My Bookings</h5>
                </div>
                <div class="card-body text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                    <h5 class="text-muted mb-3">No Bookings Yet</h5>
                    <p class="text-muted mb-4">Start exploring our vehicles and make your first booking today!</p>
                    <a href="{{ route('vehicles.rental') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i> Browse Available Vehicles
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-gradient {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    }
</style>
@endsection
