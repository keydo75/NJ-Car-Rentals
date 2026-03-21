{{-- resources/views/vehicles/sale.blade.php --}}
@extends('layouts.app')

@section('title', 'Buy & Sell Vehicles')

@section('content')
<!-- Hero Section -->
<div class="hero-section" style="min-height: 50vh; padding: 100px 0 60px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <div class="hero-badge" style="display: inline-flex; margin-bottom: 20px;">
                        <i class="bi bi-tag me-2"></i>Quality Vehicles
                    </div>
                    <h1 class="hero-title" style="font-size: 3rem;">Buy & <span>Sell</span></h1>
                    <p class="hero-subtitle" style="max-width: 600px; margin: 0 auto;">
                        Find your dream car from our curated selection or sell your vehicle through our trusted platform.
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
                <form method="GET" action="{{ route('vehicles.sale') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="bi bi-search me-2" style="color: #d4af37;"></i>Search
                        </label>
                        <input type="text" class="form-control" name="q" placeholder="Make or model" value="{{ request('q') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">
                            <i class="bi bi-car-front me-2" style="color: #d4af37;"></i>Brand
                        </label>
                        <select class="form-select" name="brand">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                    {{ $brand }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">
                            <i class="bi bi-cash me-2" style="color: #d4af37;"></i>Price Range
                        </label>
                        <select class="form-select" name="price_range">
                            <option value="">Any Price</option>
                            <option value="0-100000" {{ request('price_range') == '0-100000' ? 'selected' : '' }}>Under ₱100k</option>
                            <option value="100000-500000" {{ request('price_range') == '100000-500000' ? 'selected' : '' }}>₱100k - ₱500k</option>
                            <option value="500000-1000000" {{ request('price_range') == '500000-1000000' ? 'selected' : '' }}>₱500k - ₱1M</option>
                            <option value="1000000+" {{ request('price_range') == '1000000+' ? 'selected' : '' }}>Over ₱1M</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">
                            <i class="bi bi-calendar me-2" style="color: #d4af37;"></i>Year
                        </label>
                        <select class="form-select" name="year">
                            <option value="">Any Year</option>
                            @for($i = date('Y'); $i >= 2010; $i--)
                                <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-funnel me-2"></i>Filter
                        </button>
                        @if(request()->hasAny(['q', 'brand', 'price_range', 'year']))
                            <a href="{{ route('vehicles.sale') }}" class="btn btn-outline-secondary">
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
        @if($vehicles->count() > 0)
        <div class="row">
            @foreach($vehicles as $vehicle)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="vehicle-card">
                    <div class="vehicle-image-wrapper">
                        <img src="{{ $vehicle->getImageUrl() }}" 
                             class="card-img-top" 
                             alt="{{ $vehicle->name }}"
                             loading="lazy">
                        <div class="vehicle-badge">
                            <span class="badge" style="background: linear-gradient(135deg, #10b981, #059669);">
                                <i class="bi bi-tag me-1"></i>For Sale
                            </span>
                        </div>
                        @if($vehicle->condition == 'new')
                        <div class="vehicle-badge" style="left: 16px; right: auto;">
                            <span class="badge" style="background: linear-gradient(135deg, #0ea5e9, #0284c7);">
                                <i class="bi bi-star me-1"></i>New
                            </span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="vehicle-card-body" style="padding: 24px;">
                        <h5 class="vehicle-title">{{ $vehicle->name }}</h5>
                        <p class="text-muted mb-3">
                            <i class="bi bi-car-front me-1" style="color: #d4af37;"></i> {{ $vehicle->brand }} {{ $vehicle->model }} • {{ $vehicle->year }}
                        </p>
                        <p class="text-muted mb-3" style="font-size: 0.9rem;">{{ Str::limit($vehicle->description, 60) }}</p>
                        
                        <div class="vehicle-meta" style="margin-bottom: 16px;">
                            <div class="vehicle-meta-item">
                                <i class="bi bi-gear"></i>{{ ucfirst($vehicle->transmission) }}
                            </div>
                            <div class="vehicle-meta-item">
                                <i class="bi bi-speedometer2"></i>{{ number_format($vehicle->mileage) }} km
                            </div>
                            <div class="vehicle-meta-item">
                                <i class="bi bi-droplet"></i>{{ ucfirst($vehicle->fuel_type) }}
                            </div>
                            <div class="vehicle-meta-item">
                                <i class="bi bi-people"></i>{{ $vehicle->seats }} Seats
                            </div>
                        </div>
                        
                        <div class="vehicle-price">
                            ₱{{ number_format($vehicle->sale_price ?? 0, 0) }}
                        </div>

                        <div class="vehicle-actions">
                            <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn btn-primary">
                                <i class="bi bi-eye me-1"></i>View Details
                            </a>
                            <a href="{{ route('contact') }}" class="btn btn-outline-primary">
                                <i class="bi bi-whatsapp"></i>Inquire
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="Page navigation">
                    {{ $vehicles->withQueryString()->links() }}
                </nav>
            </div>
        </div>
        @else
        <div class="empty-state">
            <i class="bi bi-car-front empty-state-icon"></i>
            <h3 class="empty-state-title">No Vehicles Available for Sale</h3>
            <p class="empty-state-description">No vehicles match your filters. Try different criteria.</p>
            <a href="{{ route('vehicles.sale') }}" class="btn btn-primary">
                <i class="bi bi-arrow-clockwise me-2"></i>Clear Filters
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Why Buy From Us -->
<div class="py-5" style="background: linear-gradient(180deg, #0a0f1a 0%, #0d1424 100%);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Why Buy From <span>Us</span></h2>
            <p class="section-subtitle">We ensure quality and trust in every transaction</p>
        </div>

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="feature-item" style="text-align: center; padding: 30px 20px;">
                    <div class="feature-icon" style="width: 60px; height: 60px; margin: 0 auto 16px;">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <h5 style="color: #fff; margin-bottom: 8px;">Vehicle Inspection</h5>
                    <p style="color: #8892a0; font-size: 0.9rem; margin: 0;">All vehicles undergo thorough inspection</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-item" style="text-align: center; padding: 30px 20px;">
                    <div class="feature-icon" style="width: 60px; height: 60px; margin: 0 auto 16px;">
                        <i class="bi bi-file-text"></i>
                    </div>
                    <h5 style="color: #fff; margin-bottom: 8px;">Complete Papers</h5>
                    <p style="color: #8892a0; font-size: 0.9rem; margin: 0;">OR/CR and documents verified</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-item" style="text-align: center; padding: 30px 20px;">
                    <div class="feature-icon" style="width: 60px; height: 60px; margin: 0 auto 16px;">
                        <i class="bi bi-coin"></i>
                    </div>
                    <h5 style="color: #fff; margin-bottom: 8px;">Financing Options</h5>
                    <p style="color: #8892a0; font-size: 0.9rem; margin: 0;">Bank financing available</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-item" style="text-align: center; padding: 30px 20px;">
                    <div class="feature-icon" style="width: 60px; height: 60px; margin: 0 auto 16px;">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h5 style="color: #fff; margin-bottom: 8px;">After-Sales Support</h5>
                    <p style="color: #8892a0; font-size: 0.9rem; margin: 0;">6 months warranty on select vehicles</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="py-5" style="background: linear-gradient(135deg, #0a192f, #112240);">
    <div class="container text-center">
        <h2 style="font-family: 'Playfair Display', serif; color: #fff; margin-bottom: 16px;">Want to Sell Your Vehicle?</h2>
        <p style="color: #8892a0; margin-bottom: 24px;">List your vehicle with us and reach thousands of potential buyers.</p>
        <a href="{{ route('contact') }}" class="btn btn-primary">
            <i class="bi bi-tag me-2"></i>Sell Your Car
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
        gap: 12px;
        padding-bottom: 16px;
        border-bottom: 1px solid #1d3557;
    }

    .vehicle-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
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

    .feature-item {
        background: #112240;
        border: 1px solid #1d3557;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        border-color: #d4af37;
        transform: translateY(-5px);
    }

    .feature-icon {
        background: linear-gradient(135deg, #d4af37, #b8962e);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0a192f;
        font-size: 1.5rem;
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
        const filterSelects = document.querySelectorAll('select[name="brand"], select[name="price_range"], select[name="year"]');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    });
</script>
@endsection

