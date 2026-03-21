@extends('layouts.app')

@section('title', 'Add New Vehicle')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-primary-gradient text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Add New Vehicle</h4>
                        <small class="text-white-50">Complete the form below to add a new vehicle to your inventory</small>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Validation Error!</strong> Please fix the issues below:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.vehicles.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Vehicle Type & Status -->
                        <div class="card border-0 bg-light mb-4">
                            <div class="card-header bg-transparent border-bottom">
                                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="type" class="form-label fw-semibold">Vehicle Type <span class="text-danger">*</span></label>
                                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                            <option value="">-- Select Type --</option>
                                            <option value="rental" {{ old('type') === 'rental' ? 'selected' : '' }}>For Rental</option>
                                            <option value="sale" {{ old('type') === 'sale' ? 'selected' : '' }}>For Sale</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                            <option value="">-- Select Status --</option>
                                            <option value="available" {{ old('status', 'available') === 'available' ? 'selected' : '' }}>Available</option>
                                            <option value="unavailable" {{ old('status') === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Details -->
                        <div class="card border-0 bg-light mb-4">
                            <div class="card-header bg-transparent border-bottom">
                                <h6 class="mb-0"><i class="bi bi-car-front me-2"></i>Vehicle Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="make" class="form-label fw-semibold">Make <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('make') is-invalid @enderror" id="make" name="make" value="{{ old('make') }}" placeholder="e.g. Toyota" required>
                                        @error('make')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="model" class="form-label fw-semibold">Model <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('model') is-invalid @enderror" id="model" name="model" value="{{ old('model') }}" placeholder="e.g. Camry" required>
                                        @error('model')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="year" class="form-label fw-semibold">Year <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" required>
                                        @error('year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="plate_number" class="form-label fw-semibold">Plate Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('plate_number') is-invalid @enderror" id="plate_number" name="plate_number" value="{{ old('plate_number') }}" placeholder="e.g. ABC-1234" required>
                                        @error('plate_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="transmission" class="form-label fw-semibold">Transmission <span class="text-danger">*</span></label>
                                        <select class="form-select @error('transmission') is-invalid @enderror" id="transmission" name="transmission" required>
                                            <option value="">-- Select Transmission --</option>
                                            <option value="manual" {{ old('transmission') === 'manual' ? 'selected' : '' }}>Manual</option>
                                            <option value="automatic" {{ old('transmission', 'automatic') === 'automatic' ? 'selected' : '' }}>Automatic</option>
                                        </select>
                                        @error('transmission')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="seats" class="form-label fw-semibold">Number of Seats <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('seats') is-invalid @enderror" id="seats" name="seats" value="{{ old('seats', 5) }}" min="1" max="20" required>
                                        @error('seats')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="fuel_type" class="form-label fw-semibold">Fuel Type <span class="text-danger">*</span></label>
                                        <select class="form-select @error('fuel_type') is-invalid @enderror" id="fuel_type" name="fuel_type" required>
                                            <option value="">-- Select Fuel Type --</option>
                                            <option value="gasoline" {{ old('fuel_type', 'gasoline') === 'gasoline' ? 'selected' : '' }}>Gasoline</option>
                                            <option value="diesel" {{ old('fuel_type') === 'diesel' ? 'selected' : '' }}>Diesel</option>
                                            <option value="electric" {{ old('fuel_type') === 'electric' ? 'selected' : '' }}>Electric</option>
                                            <option value="hybrid" {{ old('fuel_type') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                        </select>
                                        @error('fuel_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="card border-0 bg-light mb-4">
                            <div class="card-header bg-transparent border-bottom">
                                <h6 class="mb-0"><i class="bi bi-cash-coin me-2"></i>Pricing</h6>
                            </div>
                            <div class="card-body" id="price-fields">
                                <div class="row">
                                    <div class="col-md-6 mb-3 rental-price">
                                        <label for="price_per_day" class="form-label fw-semibold">Price per Day (₱) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('price_per_day') is-invalid @enderror" id="price_per_day" name="price_per_day" value="{{ old('price_per_day') }}" min="0" step="0.01" placeholder="1500.00">
                                        @error('price_per_day')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3 sale-price" style="display: none;">
                                        <label for="sale_price" class="form-label fw-semibold">Sale Price (₱) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" value="{{ old('sale_price') }}" min="0" step="0.01" placeholder="500000.00">
                                        @error('sale_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="card border-0 bg-light mb-4">
                            <div class="card-header bg-transparent border-bottom">
                                <h6 class="mb-0"><i class="bi bi-file-text me-2"></i>Additional Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="features" class="form-label fw-semibold">Features</label>
                                    <input type="text" class="form-control @error('features') is-invalid @enderror" id="features" name="features" value="{{ old('features') }}" placeholder="Air Conditioning, GPS, Bluetooth (comma-separated)">
                                    @error('features')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted d-block mt-2">Separate features with commas</small>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-semibold">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Provide details about the vehicle...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Image & GPS -->
                        <div class="card border-0 bg-light mb-4">
                            <div class="card-header bg-transparent border-bottom">
                                <h6 class="mb-0"><i class="bi bi-image me-2"></i>Image & GPS Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="image" class="form-label fw-semibold">Vehicle Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted d-block mt-2">Max file size: 2MB. Supported formats: JPG, PNG, GIF</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="has_gps" name="has_gps" value="1" {{ old('has_gps') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="has_gps">
                                                Vehicle has GPS tracking capability
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="gps_enabled" name="gps_enabled" value="1" {{ old('gps_enabled') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="gps_enabled">
                                                GPS is currently enabled
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back to Vehicles
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Create Vehicle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('type').addEventListener('change', function() {
    const type = this.value;
    const rentalPrice = document.querySelector('.rental-price');
    const salePrice = document.querySelector('.sale-price');
    const pricePerDay = document.getElementById('price_per_day');
    const salePriceInput = document.getElementById('sale_price');

    if (type === 'rental') {
        rentalPrice.style.display = 'block';
        salePrice.style.display = 'none';
        pricePerDay.required = true;
        salePriceInput.required = false;
    } else if (type === 'sale') {
        rentalPrice.style.display = 'none';
        salePrice.style.display = 'block';
        pricePerDay.required = false;
        salePriceInput.required = true;
    } else {
        rentalPrice.style.display = 'none';
        salePrice.style.display = 'none';
        pricePerDay.required = false;
        salePriceInput.required = false;
    }
});

// Trigger change event on page load to set initial state
document.getElementById('type').dispatchEvent(new Event('change'));
</script>
@endsection