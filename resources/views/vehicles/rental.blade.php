{{-- resources/views/vehicles/rental.blade.php --}}
@extends('layouts.app')

@section('title', 'Rent a Car')

@section('content')
<!-- Hero Section -->
<div class="hero-section" style="min-height: 50vh; padding: 100px 0 60px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <div class="hero-badge" style="display: inline-flex; margin-bottom: 20px;">
                        <i class="bi bi-car-front me-2"></i>Premium Fleet
                    </div>
                    <h1 class="hero-title" style="font-size: 3rem;">Rent a <span>Car</span></h1>
                    <p class="hero-subtitle" style="max-width: 600px; margin: 0 auto;">
                        Browse our selection of well-maintained vehicles for your journey. Competitive prices with transparent terms.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="py-4" style="background: #0a0f1a;">
    <div class="container">
        <div class="card" style="background: #112240; border: 1px solid #1d3557;">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('vehicles.rental') }}" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label">
                            <i class="bi bi-search me-2" style="color: #d4af37;"></i>Search
                        </label>
                        <input type="text" class="form-control" name="q" placeholder="Make, model, or plate number" value="{{ request('q') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="bi bi-cash me-2" style="color: #d4af37;"></i>Price Range
                        </label>
                        <select class="form-select" name="price_range">
                            <option value="">Any Price</option>
                            <option value="0-2000" {{ request('price_range') == '0-2000' ? 'selected' : '' }}>₱0 - ₱2,000/day</option>
                            <option value="2000-4000" {{ request('price_range') == '2000-4000' ? 'selected' : '' }}>₱2,000 - ₱4,000/day</option>
                            <option value="4000-6000" {{ request('price_range') == '4000-6000' ? 'selected' : '' }}>₱4,000 - ₱6,000/day</option>
                            <option value="6000+" {{ request('price_range') == '6000+' ? 'selected' : '' }}>₱6,000+/day</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-funnel me-2"></i>Filter
                        </button>
                        @if(request()->has('q') || request()->has('price_range'))
                            <a href="{{ route('vehicles.rental') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Vehicles Grid -->
<div class="py-5" style="background: #0a0f1a;">
    <div class="container">
        <div class="row" id="vehicles">
            @if($vehicles->count() > 0)
                @foreach($vehicles as $vehicle)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="vehicle-card">
                        <div class="vehicle-image-wrapper">
                            <img src="{{ $vehicle->getImageUrl() }}" 
                                 class="card-img-top" 
                                 alt="{{ $vehicle->name }}"
                                 loading="lazy">
                            <div class="vehicle-badge">
                                @if($vehicle->status !== 'available' || $vehicle->rented_until)
                                    @if($vehicle->rental_status === 'pending')
                                        <span class="badge" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                            <i class="bi bi-clock-history me-1"></i>Pending Until {{ \Carbon\Carbon::parse($vehicle->rented_until)->format('M d, Y') }}
                                        </span>
                                    @elseif($vehicle->rented_until)
                                        <span class="badge" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                                            <i class="bi bi-x-circle me-1"></i>Rented Until {{ \Carbon\Carbon::parse($vehicle->rented_until)->format('M d, Y') }}
                                        </span>
                                    @else
                                        <span class="badge" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                                            <i class="bi bi-x-circle me-1"></i>{{ ucfirst($vehicle->status) }}
                                        </span>
                                    @endif
                                @else
                                    <span class="badge" style="background: linear-gradient(135deg, #10b981, #059669);">
                                        <i class="bi bi-check-circle me-1"></i>Available Now
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="vehicle-card-body" style="padding: 24px;">
                            <h5 class="vehicle-title">{{ $vehicle->name }}</h5>
                            <p class="text-muted mb-3">
                                <i class="bi bi-car-front me-1" style="color: #d4af37;"></i> {{ $vehicle->brand }} {{ $vehicle->model }} • {{ $vehicle->year }}
                            </p>
                            <p class="text-muted mb-3" style="font-size: 0.9rem;">{{ Str::limit($vehicle->description, 80) }}</p>
                            
                            <div class="vehicle-meta" style="margin-bottom: 16px;">
                                <div class="vehicle-meta-item">
                                    <i class="bi bi-gear"></i>{{ ucfirst($vehicle->transmission ?? 'Automatic') }}
                                </div>
                                <div class="vehicle-meta-item">
                                    <i class="bi bi-people"></i>{{ $vehicle->seats ?? 5 }} Seats
                                </div>
                                @if($vehicle->fuel_type)
                                <div class="vehicle-meta-item">
                                    <i class="bi bi-fuel-pump"></i>{{ ucfirst($vehicle->fuel_type) }}
                                </div>
                                @endif
                            </div>
                            
                            <div class="vehicle-price">
                                ₱{{ number_format($vehicle->price_per_day, 2) }}
                                <span class="price-period">/day</span>
                            </div>

                            <div class="vehicle-actions">
                                <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn btn-primary">
                                    <i class="bi bi-eye me-1"></i>View Details
                                </a>
                                <a href="{{ route('vehicles.rental') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-calendar-plus"></i>Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-car-front empty-state-icon"></i>
                        <h3 class="empty-state-title">No Vehicles Available</h3>
                        <p class="empty-state-description">Check back later for new additions to our fleet.</p>
                        <a href="{{ route('vehicles.rental') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-clockwise me-2"></i>Clear Filters
                        </a>
                    </div>
                </div>
            @endif
        </div>

        @if($vehicles->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="Page navigation">
                    {{ $vehicles->withQueryString()->links() }}
                </nav>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- CTA Section -->
<div class="py-5" style="background: linear-gradient(135deg, #0a192f, #112240);">
    <div class="container text-center">
        <h2 style="font-family: 'Playfair Display', serif; color: #fff; margin-bottom: 16px;">Need Help Choosing?</h2>
        <p style="color: #8892a0; margin-bottom: 24px;">Our team is ready to assist you in finding the perfect vehicle for your needs.</p>
        <a href="{{ route('contact') }}" class="btn btn-primary">
            <i class="bi bi-chat-dots me-2"></i>Contact Us
        </a>
    </div>
</div>

@endsection

@section('styles')
<style>
    .vehicle-card {
        background: #112240;
        border: 1px solid #1d3557;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .vehicle-card:hover {
        transform: translateY(-10px);
        border-color: #d4af37;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.35), 0 0 30px rgba(212, 175, 55, 0.15);
    }

    .vehicle-image-wrapper {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .vehicle-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .vehicle-card:hover .vehicle-image-wrapper img {
        transform: scale(1.08);
    }

    .vehicle-badge {
        position: absolute;
        top: 16px;
        right: 16px;
    }

    .vehicle-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 8px;
    }

    .vehicle-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #1d3557;
    }

    .vehicle-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        color: #8892a0;
    }

    .vehicle-meta-item i {
        color: #d4af37;
    }

    .vehicle-price {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: #d4af37;
        margin-bottom: 16px;
    }

    .vehicle-price .price-period {
        font-size: 0.85rem;
        font-weight: 400;
        color: #6c757d;
    }

    .vehicle-actions {
        display: flex;
        gap: 12px;
        margin-top: auto;
    }

    .vehicle-actions .btn {
        flex: 1;
        padding: 12px 16px;
        font-size: 0.9rem;
        border-radius: 10px;
    }

    .form-label {
        color: #d4af37;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        background: #0a192f;
        border: 1px solid #1d3557;
        border-radius: 10px;
        padding: 12px 16px;
        color: #e8e8e8;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        background: #112240;
        border-color: #d4af37;
        box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.15);
        color: #fff;
    }

    .form-control::placeholder {
        color: #5a6a7a;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state-icon {
        font-size: 5rem;
        color: #6c757d;
        opacity: 0.3;
        margin-bottom: 20px;
        display: block;
    }

    .empty-state-title {
        font-family: 'Playfair Display', serif;
        color: #fff;
        margin-bottom: 10px;
    }

    .empty-state-description {
        color: #6c757d;
        margin-bottom: 24px;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.25rem !important;
        }
        
        .vehicle-actions {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-submit form on select change
        const filterSelects = document.querySelectorAll('select[name="price_range"]');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
        
        // Add click animation to cards
        const cards = document.querySelectorAll('.vehicle-card');
        cards.forEach(card => {
            card.style.cursor = 'pointer';
        });
    });
</script>
@endsection

