@extends('layouts.app')

@section('title', 'Edit Vehicle')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary-gradient text-white">
                    <h4 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Vehicle</h4>
                </div>
                <div class="card-body p-4">
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

                    <form method="POST" action="{{ route('admin.vehicles.update', $vehicle) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Vehicle Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="rental" {{ old('type', $vehicle->type) === 'rental' ? 'selected' : '' }}>For Rental</option>
                                    <option value="sale" {{ old('type', $vehicle->type) === 'sale' ? 'selected' : '' }}>For Sale</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="available" {{ old('status', $vehicle->status) === 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="unavailable" {{ old('status', $vehicle->status) === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="make" class="form-label">Make <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('make') is-invalid @enderror"
                                       id="make" name="make" value="{{ old('make', $vehicle->make) }}" required>
                                @error('make')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('model') is-invalid @enderror"
                                       id="model" name="model" value="{{ old('model', $vehicle->model) }}" required>
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('year') is-invalid @enderror"
                                       id="year" name="year" value="{{ old('year', $vehicle->year) }}" min="1900" max="{{ date('Y') + 1 }}" required>
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="plate_number" class="form-label">Plate Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('plate_number') is-invalid @enderror"
                                       id="plate_number" name="plate_number" value="{{ old('plate_number', $vehicle->plate_number) }}" required>
                                @error('plate_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="transmission" class="form-label">Transmission <span class="text-danger">*</span></label>
                                <select class="form-select @error('transmission') is-invalid @enderror" id="transmission" name="transmission" required>
                                    <option value="">Select Transmission</option>
                                    <option value="manual" {{ old('transmission', $vehicle->transmission) === 'manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="automatic" {{ old('transmission', $vehicle->transmission) === 'automatic' ? 'selected' : '' }}>Automatic</option>
                                </select>
                                @error('transmission')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="seats" class="form-label">Number of Seats <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('seats') is-invalid @enderror"
                                       id="seats" name="seats" value="{{ old('seats', $vehicle->seats) }}" min="1" max="20" required>
                                @error('seats')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fuel_type" class="form-label">Fuel Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('fuel_type') is-invalid @enderror" id="fuel_type" name="fuel_type" required>
                                    <option value="">Select Fuel Type</option>
                                    <option value="gasoline" {{ old('fuel_type', $vehicle->fuel_type) === 'gasoline' ? 'selected' : '' }}>Gasoline</option>
                                    <option value="diesel" {{ old('fuel_type', $vehicle->fuel_type) === 'diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="electric" {{ old('fuel_type', $vehicle->fuel_type) === 'electric' ? 'selected' : '' }}>Electric</option>
                                    <option value="hybrid" {{ old('fuel_type', $vehicle->fuel_type) === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                                @error('fuel_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row" id="price-fields">
                            <div class="col-md-6 mb-3 rental-price">
                                <label for="price_per_day" class="form-label">Price per Day (₱) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price_per_day') is-invalid @enderror"
                                       id="price_per_day" name="price_per_day" value="{{ old('price_per_day', $vehicle->price_per_day) }}" min="0" step="0.01">
                                @error('price_per_day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3 sale-price" style="display: none;">
                                <label for="sale_price" class="form-label">Sale Price (₱) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('sale_price') is-invalid @enderror"
                                       id="sale_price" name="sale_price" value="{{ old('sale_price', $vehicle->sale_price) }}" min="0" step="0.01">
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="features" class="form-label">Features</label>
                            <input type="text" class="form-control @error('features') is-invalid @enderror"
                                   id="features" name="features" value="{{ old('features', is_array($vehicle->features) ? implode(', ', $vehicle->features) : $vehicle->features) }}"
                                   placeholder="Air Conditioning, GPS, Bluetooth (comma-separated)">
                            @error('features')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Separate features with commas</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description', $vehicle->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Vehicle Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Max file size: 2MB. Supported formats: JPG, PNG, GIF. Leave empty to keep current image.</small>
                            @if($vehicle->image_path)
                                <div class="mt-2">
                                    <small class="text-muted">Current image:</small><br>
                                    <img src="{{ asset($vehicle->image_path) }}" alt="Current vehicle image" class="img-thumbnail mt-1" style="max-width: 200px;">
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="has_gps" name="has_gps" value="1" {{ old('has_gps', $vehicle->has_gps) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="has_gps">
                                        Has GPS
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gps_enabled" name="gps_enabled" value="1" {{ old('gps_enabled', $vehicle->gps_enabled) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gps_enabled">
                                        GPS Enabled
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back to Vehicles
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Vehicle
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