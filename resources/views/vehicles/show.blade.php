
    @extends('layouts.app')

@section('title', $vehicle->name)

@section('content')
<!-- Hero Section -->
<div class="hero-section" style="min-height: 30vh; padding: 80px 0 40px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="background: transparent; padding: 0; margin-bottom: 16px;">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #8892a0;">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.rental') }}" style="color: #8892a0;">Vehicles</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: #d4af37;">{{ $vehicle->name }}</li>
                    </ol>
                </nav>
                <h1 class="hero-title" style="font-size: 2.5rem;">{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</h1>
                <p class="hero-subtitle">
                    @if($vehicle->type === 'rental')
                        Premium rental option for your journey
                    @else
                        Quality vehicle ready for ownership
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Vehicle Details -->
<div class="py-5" style="background: #0a0f1a;">
    <div class="container">
        <div class="row">
            <!-- Vehicle Image -->
            <div class="col-lg-8 mb-4">
                <div style="background: #112240; border: 1px solid #1d3557; border-radius: 20px; overflow: hidden; margin-bottom: 2rem;">
                    @if($vehicle->image_url)
                        <img src="{{ $vehicle->image_url }}" 
                             alt="{{ $vehicle->name }}"
                             style="width: 100%; height: auto; object-fit: cover; display: block;">
                    @else
                        <div style="width: 100%; height: 450px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1d3557, #112240);">
                            <i class="bi bi-car-front" style="font-size: 6rem; color: #d4af37; opacity: 0.3;"></i>
                        </div>
                    @endif
                </div>

                <!-- Vehicle Description -->
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 20px; padding: 30px;">
                    <h3 style="font-family: 'Playfair Display', serif; color: #fff; margin-bottom: 20px;">Description</h3>
                    <hr style="border-color: #1d3557;">
                    <p style="color: #8892a0; line-height: 1.8;">
                        {{ $vehicle->description ?? 'No description available for this vehicle. Please contact us for more information.' }}
                    </p>

                    <!-- Vehicle Features -->
                    <h4 style="font-family: 'Playfair Display', serif; color: #fff; margin-top: 30px; margin-bottom: 20px;">Features</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled" style="color: #8892a0;">
                                <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: #d4af37;"></i>{{ ucfirst($vehicle->transmission) }} Transmission</li>
                                <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: #d4af37;"></i>{{ $vehicle->seats }} Seats</li>
                                <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: #d4af37;"></i>{{ ucfirst($vehicle->fuel_type) }} Fuel</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled" style="color: #8892a0;">
                                <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: #d4af37;"></i>Color: {{ ucfirst($vehicle->color ?? 'N/A') }}</li>
                                <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: #d4af37;"></i>Plate: {{ $vehicle->plate_number }}</li>
                                <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: #d4af37;"></i>Year: {{ $vehicle->year }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Card -->
            <div class="col-lg-4">
                <div class="card" style="background: #112240; border: 1px solid #1d3557; border-radius: 20px; position: sticky; top: 100px;">
                    <div class="card-body p-4">
                        <!-- Type Badge -->
                        <div class="mb-3">
                            @if($vehicle->type === 'rental')
                                <span class="badge" style="background: linear-gradient(135deg, #0ea5e9, #0284c7); padding: 8px 16px; font-size: 0.85rem;">
                                    <i class="bi bi-car-front me-1"></i>For Rent
                                </span>
                            @else
                                <span class="badge" style="background: linear-gradient(135deg, #10b981, #059669); padding: 8px 16px; font-size: 0.85rem;">
                                    <i class="bi bi-tag me-1"></i>For Sale
                                </span>
                            @endif
                            <span class="badge" style="background: linear-gradient(135deg, {{ $vehicle->status === 'available' ? '#10b981, #059669' : '#ef4444, #dc2626' }}); padding: 8px 16px; font-size: 0.85rem;">
                                <i class="bi bi-{{ $vehicle->status === 'available' ? 'check-circle' : 'x-circle' }} me-1"></i>{{ ucfirst($vehicle->status) }}
                            </span>
                        </div>

                        <!-- Price -->
                        <div style="font-family: 'Playfair Display', serif; font-size: 2.25rem; font-weight: 700; color: #d4af37; margin-bottom: 20px;">
                            @if($vehicle->type === 'rental')
                                ₱{{ number_format($vehicle->price_per_day, 2) }}<span style="font-size: 1rem; font-weight: 400; color: #6c757d;">/day</span>
                            @else
                                ₱{{ number_format($vehicle->sale_price, 2) }}
                            @endif
                        </div>

                        <!-- Specs -->
                        <div style="margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid #1d3557;">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div style="display: flex; align-items: center; gap: 10px; color: #8892a0;">
                                        <div style="width: 40px; height: 40px; background: #0a192f; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-gear" style="color: #d4af37;"></i>
                                        </div>
                                        <div>
                                            <small style="display: block; color: #6c757d; font-size: 0.75rem;">Transmission</small>
                                            <span style="color: #fff; font-size: 0.9rem;">{{ ucfirst($vehicle->transmission) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div style="display: flex; align-items: center; gap: 10px; color: #8892a0;">
                                        <div style="width: 40px; height: 40px; background: #0a192f; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-people" style="color: #d4af37;"></i>
                                        </div>
                                        <div>
                                            <small style="display: block; color: #6c757d; font-size: 0.75rem;">Seats</small>
                                            <span style="color: #fff; font-size: 0.9rem;">{{ $vehicle->seats }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div style="display: flex; align-items: center; gap: 10px; color: #8892a0;">
                                        <div style="width: 40px; height: 40px; background: #0a192f; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-fuel-pump" style="color: #d4af37;"></i>
                                        </div>
                                        <div>
                                            <small style="display: block; color: #6c757d; font-size: 0.75rem;">Fuel</small>
                                            <span style="color: #fff; font-size: 0.9rem;">{{ ucfirst($vehicle->fuel_type) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div style="display: flex; align-items: center; gap: 10px; color: #8892a0;">
                                        <div style="width: 40px; height: 40px; background: #0a192f; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-palette" style="color: #d4af37;"></i>
                                        </div>
                                        <div>
                                            <small style="display: block; color: #6c757d; font-size: 0.75rem;">Color</small>
                                            <span style="color: #fff; font-size: 0.9rem;">{{ ucfirst($vehicle->color ?? 'N/A') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BOOKING FORM -->
                        @if(auth()->guard('customer')->check())
                            @if($vehicle->status === 'available')
                                @if($vehicle->type === 'rental')
                                    <form action="{{ route('rentals.store') }}" method="POST" id="bookingForm">
                                        @csrf
                                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                                        <!-- Date Selection -->
                                        <div class="mb-3">
                                            <label style="color: #d4af37; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 8px; display: block;">
                                                <i class="bi bi-calendar-range me-1"></i> Rental Period
                                            </label>
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <input type="date" name="start_date" id="startDate" class="form-control" 
                                                           min="{{ date('Y-m-d') }}" required
                                                           style="background: #0a192f; border: 2px solid #1d3557; border-radius: 12px; color: #fff; padding: 12px;">
                                                </div>
                                                <div class="col-6">
                                                    <input type="date" name="end_date" id="endDate" class="form-control" 
                                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" required
                                                           style="background: #0a192f; border: 2px solid #1d3557; border-radius: 12px; color: #fff; padding: 12px;">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Location Selection -->
                                        <div class="mb-3">
                                            <label style="color: #d4af37; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 8px; display: block;">
                                                <i class="bi bi-geo-alt me-1"></i> Pickup Location
                                            </label>
                                            <select name="pickup_location" id="pickupLocation" class="form-select" required
                                                    style="background: #0a192f; border: 2px solid #1d3557; border-radius: 12px; color: #fff; padding: 12px;">
                                                <option value="">Select pickup location</option>
                                                <option value="NJ Car Rentals - Olongapo City">NJ Car Rentals - Olongapo City</option>
                                                <option value="NJ Car Rentals - Subic Bay">NJ Car Rentals - Subic Bay</option>
                                                <option value="NJ Car Rentals - Clark">NJ Car Rentals - Clark</option>
                                                <option value="SM Olongapo">SM Olongapo</option>
                                                <option value="Olongapo City Central">Olongapo City Central</option>
                                                <option value="Kiasu Arch">Kiasu Arch</option>
                                                <option value="Custom Location">Custom Location (Specify in notes)</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label style="color: #d4af37; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 8px; display: block;">
                                                <i class="bi bi-geo-alt-fill me-1"></i> Dropoff Location
                                            </label>
                                            <select name="dropoff_location" id="dropoffLocation" class="form-select" required
                                                    style="background: #0a192f; border: 2px solid #1d3557; border-radius: 12px; color: #fff; padding: 12px;">
                                                <option value="">Select dropoff location</option>
                                                <option value="NJ Car Rentals - Olongapo City">NJ Car Rentals - Olongapo City</option>
                                                <option value="NJ Car Rentals - Subic Bay">NJ Car Rentals - Subic Bay</option>
                                                <option value="NJ Car Rentals - Clark">NJ Car Rentals - Clark</option>
                                                <option value="SM Olongapo">SM Olongapo</option>
                                                <option value="Olongapo City Central">Olongapo City Central</option>
                                                <option value="Kiasu Arch">Kiasu Arch</option>
                                                <option value="Custom Location">Custom Location (Specify in notes)</option>
                                            </select>
                                        </div>

                                        <!-- Special Requests -->
                                        <div class="mb-3">
                                            <label style="color: #d4af37; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 8px; display: block;">
                                                <i class="bi bi-chat-text me-1"></i> Special Requests
                                            </label>
                                            <textarea name="notes" class="form-control" rows="3" placeholder="Any special requests or requirements..."
                                                      style="background: #0a192f; border: 2px solid #1d3557; border-radius: 12px; color: #fff; padding: 12px; resize: none;"></textarea>
                                        </div>

                                        <!-- Price Summary -->
                                        <div id="priceSummary" class="mb-3" style="background: #0a192f; border: 2px solid #1d3557; border-radius: 12px; padding: 16px; display: none;">
                                            <h6 style="color: #d4af37; font-weight: 600; margin-bottom: 12px;">
                                                <i class="bi bi-receipt me-2"></i>Price Summary
                                            </h6>
                                            <div id="priceBreakdown" style="color: #8892a0; font-size: 0.9rem;">
                                                <!-- Dynamic pricing will be inserted here -->
                                            </div>
                                        </div>

                                        <!-- Terms & Conditions -->
                                        <div class="mb-3">
    <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="termsAccepted" name="terms_accepted" required style="cursor: pointer;">
                                                <label class="form-check-label" for="termsAccepted" style="color: #8892a0; font-size: 0.85rem; cursor: pointer;">
                                                    I agree to the <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#termsModal">Terms & Conditions</a> and <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#cancellationModal">Cancellation Policy</a> <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" class="btn btn-primary btn-lg w-100" style="padding: 16px; font-weight: 600;">
                                            <i class="bi bi-check-circle me-2"></i>Confirm Booking
                                        </button>
                                    </form>
                                @else
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary btn-lg" style="padding: 16px;" data-bs-toggle="modal" data-bs-target="#inquiryModal">
                                            <i class="bi bi-bag-check me-2"></i>Inquire to Buy
                                        </button>
                                    </div>
                                @endif
                            @else
                                <div class="alert" style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 12px; color: #fbbf24; text-align: center;">
                                    <i class="bi bi-exclamation-triangle me-2"></i>This vehicle is currently unavailable.
                                </div>
                            @endif
                        @else
                            <div class="alert" style="background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.3); border-radius: 12px; text-align: center;">
                                <a href="{{ route('customer.login') }}" style="color: #d4af37;">Log in</a> or <a href="{{ route('customer.register') }}" style="color: #d4af37;">register</a> to continue.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inquiry Modal -->
@if(auth()->guard('customer')->check())
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: #112240; border: 1px solid #1d3557; border-radius: 20px;">
      <form action="{{ route('inquiries.store', $vehicle->id) }}" method="POST">
        @csrf
        <div class="modal-header" style="border-bottom: 1px solid #1d3557; padding: 20px 24px;">
          <h5 class="modal-title" id="inquiryModalLabel" style="font-family: 'Playfair Display', serif; color: #fff;">
            <i class="bi bi-chat-dots me-2" style="color: #d4af37;"></i>Ask about {{ $vehicle->name }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
        </div>
        <div class="modal-body" style="padding: 24px;">
          <div class="mb-3">
            <label for="message" class="form-label" style="color: #d4af37; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">Your Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" required style="background: #0a192f; border: 2px solid #1d3557; border-radius: 12px; color: #fff; padding: 14px;"></textarea>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid #1d3557; padding: 16px 24px;">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-send me-2"></i>Send Inquiry
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif

<!-- Terms & Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="background: #112240; border: 1px solid #1d3557; border-radius: 20px;">
      <div class="modal-header" style="border-bottom: 1px solid #1d3557; padding: 20px 24px;">
        <h5 class="modal-title" id="termsModalLabel" style="font-family: 'Playfair Display', serif; color: #fff;">
          <i class="bi bi-file-text me-2" style="color: #d4af37;"></i>Terms & Conditions
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
      </div>
      <div class="modal-body" style="padding: 24px; color: #8892a0; max-height: 400px; overflow-y: auto;">
        <h6 style="color: #d4af37; margin-bottom: 12px;">Rental Agreement</h6>
        <p style="font-size: 0.9rem; line-height: 1.6; margin-bottom: 16px;">
            By booking this vehicle, you agree to the following terms and conditions:
        </p>
        <ul style="font-size: 0.9rem; line-height: 1.8; padding-left: 20px;">
            <li>The renter must be at least 21 years old with a valid driver's license.</li>
            <li>A security deposit is required and will be refunded upon safe return of the vehicle.</li>
            <li>The vehicle must be returned in the same condition as received.</li>
            <li>Fuel consumption is the responsibility of the renter.</li>
            <li>Late returns will incur additional charges.</li>
            <li>The vehicle is for authorized use only and cannot be used for illegal purposes.</li>
            <li> NJ Car Rentals is not liable for any injuries or accidents during the rental period.</li>
            <li>Additional drivers must be registered and meet the same requirements.</li>
        </ul>
        <h6 style="color: #d4af37; margin-bottom: 12px; margin-top: 20px;">Add-on Services</h6>
        <ul style="font-size: 0.9rem; line-height: 1.8; padding-left: 20px;">
            <li><strong>Additional Driver:</strong> ₱200 (flat) - Add another authorized driver at no extra cost per day.</li>
            <li><strong>Child Seat:</strong> ₱100 (flat) - Safety-certified child seat.</li>
        </ul>
      </div>
      <div class="modal-footer" style="border-top: 1px solid #1d3557; padding: 16px 24px;">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
      </div>
    </div>
  </div>
</div>

<!-- Cancellation Policy Modal -->
<div class="modal fade" id="cancellationModal" tabindex="-1" aria-labelledby="cancellationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: #112240; border: 1px solid #1d3557; border-radius: 20px;">
      <div class="modal-header" style="border-bottom: 1px solid #1d3557; padding: 20px 24px;">
        <h5 class="modal-title" id="cancellationModalLabel" style="font-family: 'Playfair Display', serif; color: #fff;">
          <i class="bi bi-x-circle me-2" style="color: #d4af37;"></i>Cancellation Policy
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
      </div>
      <div class="modal-body" style="padding: 24px; color: #8892a0;">
        <ul style="font-size: 0.9rem; line-height: 1.8; padding-left: 20px;">
            <li><strong>Free Cancellation:</strong> Cancel 48+ hours before pickup for full refund.</li>
            <li><strong>Partial Refund:</strong> Cancel 24-48 hours before pickup for 50% refund.</li>
            <li><strong>No Refund:</strong> Cancel less than 24 hours before pickup - no refund.</li>
            <li><strong>No-Show:</strong> If you don't pick up the vehicle at the scheduled time, the booking will be canceled without refund.</li>
            <li><strong>Early Return:</strong> No refund for early returns unless due to vehicle breakdown.</li>
        </ul>
      </div>
      <div class="modal-footer" style="border-top: 1px solid #1d3557; padding: 16px 24px;">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('styles')
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

    .form-label {
        color: #d4af37;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        background: #0a192f;
        border: 2px solid #1d3557;
        border-radius: 12px;
        padding: 14px 16px;
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

    .form-check-input:checked {
        background-color: #d4af37;
        border-color: #d4af37;
    }

    .addon-item:hover {
        border-color: #d4af37 !important;
    }

    .addon-item.selected {
        border-color: #d4af37 !important;
        background: rgba(212, 175, 55, 0.1) !important;
    }

    .addon-item.selected .addon-check {
        background: #d4af37 !important;
        border-color: #d4af37 !important;
    }

    .addon-item.selected .addon-check i {
        display: block !important;
        color: #0a0f1a !important;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .modal-content::-webkit-scrollbar {
        width: 8px;
    }

    .modal-content::-webkit-scrollbar-track {
        background: #0a192f;
    }

    .modal-content::-webkit-scrollbar-thumb {
        background: #1d3557;
        border-radius: 4px;
    }
</style>
@endsection

@section('scripts')
<script>
    // Booked date ranges from server (for confirmed, ongoing, and pending bookings)
    const bookedRanges = @json($bookedRanges);
    
    // Get all booked dates as an array
    function getAllBookedDates() {
        const allDates = [];
        bookedRanges.forEach(range => {
            const start = new Date(range.start);
            const end = new Date(range.end);
            const current = new Date(start);
            
            while (current <= end) {
                allDates.push(current.toISOString().split('T')[0]);
                current.setDate(current.getDate() + 1);
            }
        });
        return allDates;
    }
    
    const bookedDates = getAllBookedDates();

    // Toggle addon selection
    function toggleAddon(element) {
        const checkbox = element.querySelector('.addon-checkbox');
        checkbox.checked = !checkbox.checked;
        
        if (checkbox.checked) {
            element.classList.add('selected');
        } else {
            element.classList.remove('selected');
        }
        
        // Trigger price calculation
        calculatePrice();
    }

    // Check if a date is booked
    function isDateBooked(dateString) {
        return bookedDates.includes(dateString);
    }
    
    // Check if selected dates overlap with booked dates
    function hasDateConflict(startDate, endDate) {
        if (!startDate || !endDate) return false;
        
        const start = new Date(startDate);
        const end = new Date(endDate);
        
        for (let d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
            const dateStr = d.toISOString().split('T')[0];
            if (isDateBooked(dateStr)) {
                return true;
            }
        }
        return false;
    }

    // Calculate price when dates or addons change
    function calculatePrice() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        if (!startDate || !endDate) {
            document.getElementById('priceSummary').style.display = 'none';
            return;
        }

        // Check for date conflicts
        const conflict = hasDateConflict(startDate, endDate);
        const priceSummary = document.getElementById('priceSummary');
        
        if (conflict) {
            priceSummary.style.display = 'block';
            document.getElementById('priceBreakdown').innerHTML = `
                <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; padding: 16px; text-align: center;">
                    <i class="bi bi-exclamation-triangle me-2" style="color: #ef4444;"></i>
                    <span style="color: #ef4444; font-weight: 600;">These dates are not available</span>
                    <p style="color: #ef4444; font-size: 0.85rem; margin-top: 8px; margin-bottom: 0;">
                        Some or all of the selected dates are already booked. Please choose different dates.
                    </p>
                </div>
            `;
            return;
        }

        // Get selected addons
        const addons = [];
        document.querySelectorAll('.addon-checkbox:checked').forEach(checkbox => {
            addons.push(checkbox.value);
        });

        // Make AJAX request
        fetch(`{{ route('rentals.calculatePrice') }}?vehicle_id={{ $vehicle->id }}&start_date=${startDate}&end_date=${endDate}&addons=${addons.join(',')}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }
                
                // Build price breakdown HTML
                let breakdownHTML = `
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Vehicle (${data.days} day${data.days > 1 ? 's' : ''} × ₱${data.price_per_day})</span>
                        <span>₱${data.vehicle_subtotal.toFixed(2)}</span>
                    </div>
                `;
                
                if (data.addons_price > 0) {
                    breakdownHTML += `
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span>Add-ons</span>
                            <span>₱${data.addons_price.toFixed(2)}</span>
                        </div>
                    `;
                    
                    // List each addon
                    for (const [key, addon] of Object.entries(data.addons_details || {})) {
                        breakdownHTML += `
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px; padding-left: 16px; font-size: 0.8rem; color: #6c757d;">
                                <span>• ${addon.name}</span>
                                <span>₱${addon.price.toFixed(2)}</span>
                            </div>
                        `;
                    }
                }
                
                breakdownHTML += `
                    <hr style="border-color: #1d3557; margin: 12px 0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Subtotal</span>
                        <span>₱${data.subtotal.toFixed(2)}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Tax (12%)</span>
                        <span>₱${data.tax_amount.toFixed(2)}</span>
                    </div>
                    <hr style="border-color: #1d3557; margin: 12px 0;">
                    <div style="display: flex; justify-content: space-between; font-weight: 700; color: #d4af37; font-size: 1.1rem;">
                        <span>Total</span>
                        <span>₱${data.total_price.toFixed(2)}</span>
                    </div>
                `;
                
                document.getElementById('priceBreakdown').innerHTML = breakdownHTML;
                document.getElementById('priceSummary').style.display = 'block';
            })
            .catch(error => {
                console.error('Error calculating price:', error);
            });
    }

    // Initialize date pickers with booked dates disabled
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');
        
        // Apply date validation on input click to show calendar with disabled dates
        [startDateInput, endDateInput].forEach(input => {
            // Style the input to show it's date-limited
            input.style.cursor = 'pointer';
            
            // Validate on change
            input.addEventListener('change', function() {
                const selectedDate = this.value;
                
                if (selectedDate && isDateBooked(selectedDate)) {
                    alert('This date is already booked. Please select different dates.');
                    this.value = '';
                }
                
                // Recalculate price
                calculatePrice();
            });
            
            // Also validate on input (for manual typing)
            input.addEventListener('input', function() {
                const selectedDate = this.value;
                
                if (selectedDate && isDateBooked(selectedDate)) {
                    // Don't immediately clear, but show visual feedback
                    this.setCustomValidity('This date is already booked');
                } else {
                    this.setCustomValidity('');
                }
            });
        });
        
        // Update end date min when start date changes
        startDateInput.addEventListener('change', function() {
            if (this.value) {
                const startDate = new Date(this.value);
                const nextDay = new Date(startDate);
                nextDay.setDate(nextDay.getDate() + 1);
                
                // Update end date min
                const minEndDate = nextDay.toISOString().split('T')[0];
                if (endDateInput.value && endDateInput.value <= this.value) {
                    endDateInput.value = minEndDate;
                }
                endDateInput.min = minEndDate;
            }
            calculatePrice();
        });
        
        endDateInput.addEventListener('change', calculatePrice);
    });

    // Validate form on submit
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        const startDate = new Date(document.getElementById('startDate').value);
        const endDate = new Date(document.getElementById('endDate').value);
        
        if (endDate <= startDate) {
            e.preventDefault();
            alert('End date must be after start date');
            return;
        }
        
        // Check for date conflicts
        if (hasDateConflict(document.getElementById('startDate').value, document.getElementById('endDate').value)) {
            e.preventDefault();
            alert('Some or all of the selected dates are already booked. Please choose different dates.');
            return;
        }
        
        const pickup = document.getElementById('pickupLocation').value;
        const dropoff = document.getElementById('dropoffLocation').value;
        
        if (!pickup || !dropoff) {
            e.preventDefault();
            alert('Please select both pickup and dropoff locations');
            return;
        }
    });
</script>
@endsection


