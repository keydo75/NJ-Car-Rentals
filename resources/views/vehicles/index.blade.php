@extends('layouts.app')

@section('title', 'Search Vehicles')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div style="background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%); border-radius: 12px; padding: 40px; color: white;">
                <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">
                    <i class="bi bi-search"></i> Search Results
                </h1>
                <p style="font-size: 1.1rem; color: rgba(255,255,255,0.9);">
                    Found {{ $vehicles->total() }} vehicle{{ $vehicles->total() !== 1 ? 's' : '' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Search Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div style="background: #1a1a1a; border: 1px solid #333; border-radius: 12px; padding: 25px;">
                <form method="GET" action="{{ route('vehicles.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label style="display: block; margin-bottom: 8px; color: #fff; font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">
                            <i class="bi bi-search me-2"></i>Search Query
                        </label>
                        <input type="text" 
                               name="q" 
                               class="form-control" 
                               placeholder="Make, model, or plate number"
                               value="{{ request('q') }}"
                               style="background: #2a2a2a; border-color: #444; color: white; padding: 12px 15px;">
                    </div>

                    <div class="col-md-3">
                        <label style="display: block; margin-bottom: 8px; color: #fff; font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">
                            <i class="bi bi-tag me-2"></i>Max Price
                        </label>
                        <input type="number" 
                               name="max_price" 
                               class="form-control" 
                               placeholder="e.g., 5000"
                               value="{{ request('max_price') }}"
                               style="background: #2a2a2a; border-color: #444; color: white; padding: 12px 15px;">
                    </div>

                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn" style="background: #0066cc; color: white; font-weight: 600; padding: 12px 30px;">
                            <i class="bi bi-search me-2"></i>Search
                        </button>
                        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-2"></i>Clear Filters
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Vehicles Grid -->
    <div class="row mb-4">
        @forelse($vehicles as $vehicle)
            <div class="col-md-6 col-lg-4 mb-4">
                <div style="background: #1a1a1a; border: 1px solid #333; border-radius: 12px; overflow: hidden; transition: all 0.3s ease; height: 100%; display: flex; flex-direction: column;"
                     onmouseover="this.style.borderColor='#0066cc'; this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(0, 102, 204, 0.2)'"
                     onmouseout="this.style.borderColor='#333'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    
                    <!-- Vehicle Image -->
                    <div style="width: 100%; height: 200px; background: #2a2a2a; overflow: hidden; position: relative;">
                        @if($vehicle->image_url)
                            <img src="{{ $vehicle->image_url }}" 
                                 alt="{{ $vehicle->make }} {{ $vehicle->model }}"
                                 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #666;">
                                <i class="bi bi-image" style="font-size: 3rem;"></i>
                            </div>
                        @endif

                        <!-- Type Badge -->
                        <div style="position: absolute; top: 12px; left: 12px;">
                            <span style="background: #0066cc; color: white; padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">
                                {{ ucfirst($vehicle->type) }}
                            </span>
                        </div>

                        <!-- Status Badge -->
                        <div style="position: absolute; top: 12px; right: 12px;">
                            <span style="background: {{ $vehicle->status === 'available' ? '#2ecc71' : '#e74c3c' }}; color: white; padding: 6px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                                {{ ucfirst($vehicle->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Vehicle Info -->
                    <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column;">
                        <!-- Title -->
                        <h4 style="font-size: 1.2rem; font-weight: 700; color: white; margin-bottom: 8px;">
                            {{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}
                        </h4>

                        <!-- Specs -->
                        <div style="font-size: 0.85rem; color: #909090; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #333; display: flex; gap: 12px; flex-wrap: wrap;">
                            <span><i class="bi bi-gear me-1" style="color: #0066cc;"></i>{{ ucfirst($vehicle->transmission) }}</span>
                            <span><i class="bi bi-people me-1" style="color: #0066cc;"></i>{{ $vehicle->seats }} Seats</span>
                            <span><i class="bi bi-fuel-pump me-1" style="color: #0066cc;"></i>{{ ucfirst($vehicle->fuel_type) }}</span>
                        </div>

                        <!-- Plate Number -->
                        <p style="font-size: 0.9rem; color: #b0b0b0; margin-bottom: 12px;">
                            <i class="bi bi-tag me-2" style="color: #0066cc;"></i><strong>Plate:</strong> {{ $vehicle->plate_number }}
                        </p>

                        <!-- Price -->
                        <div style="font-size: 1.4rem; font-weight: 700; color: #0066cc; margin-top: auto; margin-bottom: 15px;">
                            @if($vehicle->type === 'rental')
                                ₱{{ number_format($vehicle->price_per_day, 2) }}<span style="font-size: 0.7rem; color: #909090;">/day</span>
                            @else
                                ₱{{ number_format($vehicle->sale_price, 2) }}
                            @endif
                        </div>

                        <!-- Buttons -->
                        <div style="display: flex; gap: 10px;">
                            <a href="{{ route('vehicles.show', $vehicle->id) }}" 
                               class="btn btn-sm"
                               style="background: #0066cc; color: white; text-decoration: none; padding: 10px 15px; border-radius: 6px; font-weight: 600; flex: 1; text-align: center; transition: all 0.3s ease;"
                               onmouseover="this.style.background='#0052a3'"
                               onmouseout="this.style.background='#0066cc'">
                                <i class="bi bi-eye me-1"></i>View Details
                            </a>
                            @if($vehicle->type === 'rental')
                                <a href="{{ route('vehicles.rental') }}" 
                                   class="btn btn-sm"
                                   style="background: #2a2a2a; color: white; text-decoration: none; padding: 10px 15px; border-radius: 6px; border: 1px solid #444; font-weight: 600; flex: 1; text-align: center; transition: all 0.3s ease;"
                                   onmouseover="this.style.background='#333'; this.style.borderColor='#0066cc'"
                                   onmouseout="this.style.background='#2a2a2a'; this.style.borderColor='#444'">
                                    <i class="bi bi-calendar me-1"></i>Rent
                                </a>
                            @else
                                <a href="{{ route('vehicles.sale') }}" 
                                   class="btn btn-sm"
                                   style="background: #2a2a2a; color: white; text-decoration: none; padding: 10px 15px; border-radius: 6px; border: 1px solid #444; font-weight: 600; flex: 1; text-align: center; transition: all 0.3s ease;"
                                   onmouseover="this.style.background='#333'; this.style.borderColor='#0066cc'"
                                   onmouseout="this.style.background='#2a2a2a'; this.style.borderColor='#444'">
                                    <i class="bi bi-bag me-1"></i>Inquire
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="col-12">
                <div style="background: #1a1a1a; border: 2px dashed #333; border-radius: 12px; padding: 60px; text-align: center;">
                    <i class="bi bi-search" style="font-size: 4rem; color: #333; display: block; margin-bottom: 20px;"></i>
                    <h3 style="color: white; margin-bottom: 10px;">No Vehicles Found</h3>
                    <p style="color: #909090; margin-bottom: 20px;">
                        We couldn't find any vehicles matching your search criteria. Try adjusting your filters or search terms.
                    </p>
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <a href="{{ route('vehicles.index') }}" 
                           class="btn"
                           style="background: #0066cc; color: white; text-decoration: none; padding: 12px 25px; border-radius: 6px; font-weight: 600;">
                            <i class="bi bi-arrow-clockwise me-2"></i>Clear All Filters
                        </a>
                        <a href="{{ route('vehicles.rental') }}" 
                           class="btn"
                           style="background: #2a2a2a; color: white; text-decoration: none; padding: 12px 25px; border-radius: 6px; font-weight: 600; border: 1px solid #444;">
                            <i class="bi bi-car me-2"></i>Browse Rental Cars
                        </a>
                        <a href="{{ route('vehicles.sale') }}" 
                           class="btn"
                           style="background: #2a2a2a; color: white; text-decoration: none; padding: 12px 25px; border-radius: 6px; font-weight: 600; border: 1px solid #444;">
                            <i class="bi bi-bag me-2"></i>Browse For Sale
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($vehicles->count() > 0)
        <div class="row">
            <div class="col-12">
                <nav style="display: flex; justify-content: center;">
                    {{ $vehicles->appends(request()->query())->links() }}
                </nav>
            </div>
        </div>
    @endif
</div>

<style>
    /* Bootstrap pagination styling for dark theme */
    .pagination {
        gap: 8px;
    }

    .page-link {
        background: #2a2a2a;
        color: white;
        border: 1px solid #444;
        border-radius: 6px;
    }

    .page-link:hover {
        background: #0066cc;
        border-color: #0066cc;
        color: white;
    }

    .page-item.active .page-link {
        background: #0066cc;
        border-color: #0066cc;
    }

    .form-control {
        background: #2a2a2a !important;
        border-color: #444 !important;
        color: white !important;
    }

    .form-control::placeholder {
        color: #666 !important;
    }

    .form-control:focus {
        background: #2a2a2a !important;
        border-color: #0066cc !important;
        color: white !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25) !important;
    }

    .btn-outline-secondary {
        color: #909090;
        border-color: #444;
    }

    .btn-outline-secondary:hover {
        background: #333;
        border-color: #0066cc;
        color: white;
    }
</style>
@endsection
