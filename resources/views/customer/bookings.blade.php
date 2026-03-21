@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<!-- Hero Section -->
<div class="hero-section" style="min-height: 25vh; padding: 80px 0 40px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="background: transparent; padding: 0; margin-bottom: 16px;">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #8892a0;">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}" style="color: #8892a0;">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: #d4af37;">My Bookings</li>
                    </ol>
                </nav>
                <h1 class="hero-title" style="font-size: 2.5rem;">My Bookings</h1>
                <p class="hero-subtitle">
                    View and manage your car rental bookings
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Bookings Content -->
<div class="py-5" style="background: #0a0f1a;">
    <div class="container">
        
        <!-- Status Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 16px;">
                    <div class="card-body text-center">
                        <div style="width: 50px; height: 50px; background: rgba(212, 175, 55, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                            <i class="bi bi-calendar-check" style="color: #d4af37; font-size: 1.5rem;"></i>
                        </div>
                        <h3 style="color: #fff; font-weight: 700; margin-bottom: 4px;">{{ $bookings->count() }}</h3>
                        <p style="color: #8892a0; font-size: 0.85rem; margin-bottom: 0;">Total Bookings</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 16px;">
                    <div class="card-body text-center">
                        <div style="width: 50px; height: 50px; background: rgba(245, 158, 11, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                            <i class="bi bi-calendar-event" style="color: #f59e0b; font-size: 1.5rem;"></i>
                        </div>
                        <h3 style="color: #fff; font-weight: 700; margin-bottom: 4px;">
                            {{ $bookings->filter(function($booking) {
                                return in_array($booking->status, ['pending', 'confirmed']) && \Carbon\Carbon::parse($booking->start_date)->isFuture();
                            })->count() }}
                        </h3>
                        <p style="color: #8892a0; font-size: 0.85rem; margin-bottom: 0;">Upcoming</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 16px;">
                    <div class="card-body text-center">
                        <div style="width: 50px; height: 50px; background: rgba(139, 92, 246, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                            <i class="bi bi-play-circle" style="color: #8b5cf6; font-size: 1.5rem;"></i>
                        </div>
                        <h3 style="color: #fff; font-weight: 700; margin-bottom: 4px;">{{ $bookings->where('status', 'ongoing')->count() }}</h3>
                        <p style="color: #8892a0; font-size: 0.85rem; margin-bottom: 0;">Ongoing</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 16px;">
                    <div class="card-body text-center">
                        <div style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                            <i class="bi bi-check2-all" style="color: #10b981; font-size: 1.5rem;"></i>
                        </div>
                        <h3 style="color: #fff; font-weight: 700; margin-bottom: 4px;">{{ $bookings->where('status', 'completed')->count() }}</h3>
                        <p style="color: #8892a0; font-size: 0.85rem; margin-bottom: 0;">Completed</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings List -->
        @if($bookings->count())
            <div class="row">
                @foreach($bookings as $booking)
                    <div class="col-lg-6 mb-4">
                        <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 20px; overflow: hidden;">
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    <!-- Vehicle Image -->
                                    <div class="col-md-5">
                                        @if($booking->vehicle && $booking->vehicle->image_url)
                                            <img src="{{ $booking->vehicle->image_url }}" 
                                                 alt="{{ $booking->vehicle->name ?? 'Vehicle' }}"
                                                 style="width: 100%; height: 100%; object-fit: cover; min-height: 180px;">
                                        @else
                                            <div style="width: 100%; height: 100%; min-height: 180px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1d3557, #112240);">
                                                <i class="bi bi-car-front" style="font-size: 4rem; color: #d4af37; opacity: 0.3;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Booking Details -->
                                    <div class="col-md-7">
                                        <div class="p-4">
                                            <!-- Status Badge -->
                                            <div class="mb-3">
                                                @php
                                                    $statusConfig = [
                                                        'pending' => ['bg' => 'rgba(245, 158, 11, 0.15)', 'color' => '#f59e0b', 'icon' => 'hourglass-split', 'label' => 'Pending'],
                                                        'confirmed' => ['bg' => 'rgba(59, 130, 246, 0.15)', 'color' => '#3b82f6', 'icon' => 'check-circle', 'label' => 'Confirmed'],
                                                        'ongoing' => ['bg' => 'rgba(139, 92, 246, 0.15)', 'color' => '#8b5cf6', 'icon' => 'play-circle', 'label' => 'Ongoing'],
                                                        'completed' => ['bg' => 'rgba(16, 185, 129, 0.15)', 'color' => '#10b981', 'icon' => 'check2-all', 'label' => 'Completed'],
                                                        'cancelled' => ['bg' => 'rgba(239, 68, 68, 0.15)', 'color' => '#ef4444', 'icon' => 'x-circle', 'label' => 'Cancelled'],
                                                    ];
                                                    $status = $statusConfig[$booking->status] ?? $statusConfig['pending'];
                                                @endphp
                                                <span class="badge" style="background: {{ $status['bg'] }}; color: {{ $status['color'] }}; padding: 8px 14px; font-size: 0.8rem; font-weight: 500;">
                                                    <i class="bi bi-{{ $status['icon'] }} me-1"></i>{{ $status['label'] }}
                                                </span>
                                            </div>
                                            
                                            <!-- Vehicle Name -->
                                            <h5 style="color: #fff; font-weight: 600; margin-bottom: 12px; font-family: 'Playfair Display', serif;">
                                                {{ $booking->vehicle->year ?? '' }} {{ $booking->vehicle->make ?? 'N/A' }} {{ $booking->vehicle->model ?? '' }}
                                            </h5>
                                            

                                                <div class="d-flex align-items-center gap-2 mb-2" style="color: #8892a0; font-size: 0.9rem;">
                                                    <i class="bi bi-calendar-event" style="color: #d4af37;"></i>
                                                    <span>{{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}</span>
                                                    <i class="bi bi-arrow-right" style="color: #8892a0;"></i>
                                                    <span>{{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" style="color: #8892a0; font-size: 0.9rem;">
                                                    <i class="bi bi-clock" style="color: #d4af37;"></i>
                                                    <span>{{ $booking->days }} day(s)</span>
                                                </div>
                                            </div>
                                            
                                            <!-- Price -->
                                            <div style="margin-bottom: 16px;">
                                                <span style="color: #8892a0; font-size: 0.85rem;">Total Price</span>
                                                <div style="color: #d4af37; font-size: 1.5rem; font-weight: 700; font-family: 'Playfair Display', serif;">
                                                    ₱{{ number_format($booking->total_price, 2) }}
                                                </div>
                                            </div>
                                            
                                            <!-- Actions -->
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('vehicles.show', $booking->vehicle_id) }}" class="btn btn-sm" style="background: rgba(212, 175, 55, 0.15); color: #d4af37; border: 1px solid rgba(212, 175, 55, 0.3);">
                                                    <i class="bi bi-eye me-1"></i> View
                                                </a>
                                                @if(in_array($booking->status, ['pending', 'confirmed']))
                                                    <form method="POST" action="{{ route('customer.bookings.cancel', $booking->id) }}" style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3);" onclick="return confirm('Are you sure you want to cancel this booking?');">
                                                            <i class="bi bi-x-circle me-1"></i> Cancel
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 20px;">
                <div class="card-body text-center py-5">
                    <div style="width: 120px; height: 120px; background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(212, 175, 55, 0.05)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class="bi bi-car-front" style="font-size: 3rem; color: #d4af37; opacity: 0.5;"></i>
                    </div>
                    <h3 style="color: #fff; font-family: 'Playfair Display', serif; margin-bottom: 12px;">No Bookings Yet</h3>
                    <p style="color: #8892a0; margin-bottom: 24px; max-width: 400px; margin-left: auto; margin-right: auto;">
                        Start your journey with NJ Car Rentals! Browse our available vehicles and make your first booking today.
                    </p>
                    <a href="{{ route('vehicles.rental') }}" class="btn btn-lg" style="background: linear-gradient(135deg, #d4af37, #b8962e); color: #0a0f1a; font-weight: 600; padding: 14px 32px; border: none;">
                        <i class="bi bi-car-front me-2"></i> Browse Available Vehicles
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .hero-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 8px;
    }

    .hero-subtitle {
        font-size: 1.1rem;
        color: #8892a0;
    }

    .breadcrumb-item a {
        color: #8892a0 !important;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb-item a:hover {
        color: #d4af37 !important;
    }

    .breadcrumb-item.active {
        color: #d4af37 !important;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
    }

    .btn:hover {
        transform: translateY(-2px);
    }
</style>
@endsection

