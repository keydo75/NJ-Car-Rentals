@extends('layouts.app')

@section('title', 'Rental Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Rental Details Card -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-primary-gradient text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Rental Details</h4>
                    <div>
                        <a href="{{ route('admin.rentals.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left me-1"></i>Back to Rentals
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <!-- Vehicle Information -->
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase mb-3">Vehicle Information</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td class="border-0"><strong>Vehicle:</strong></td>
                                    <td class="border-0">{{ $rental->vehicle->year }} {{ $rental->vehicle->make }} {{ $rental->vehicle->model }}</td>
                                </tr>
                                <tr>
                                    <td class="border-0"><strong>Plate Number:</strong></td>
                                    <td class="border-0">{{ $rental->vehicle->plate_number }}</td>
                                </tr>
                                <tr>
                                    <td class="border-0"><strong>Type:</strong></td>
                                    <td class="border-0">
                                        <span class="badge bg-{{ $rental->vehicle->type === 'rental' ? 'info' : 'success' }}">
                                            {{ ucfirst($rental->vehicle->type) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0"><strong>Transmission:</strong></td>
                                    <td class="border-0">{{ ucfirst($rental->vehicle->transmission) }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Customer Information -->
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase mb-3">Customer Information</h6>
                            @if($rental->user)
                                <table class="table table-sm">
                                    <tr>
                                        <td class="border-0"><strong>Name:</strong></td>
                                        <td class="border-0">{{ $rental->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-0"><strong>Email:</strong></td>
                                        <td class="border-0">
                                            <a href="mailto:{{ $rental->user->email }}" class="text-decoration-none">
                                                {{ $rental->user->email }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-0"><strong>Phone:</strong></td>
                                        <td class="border-0">
                                            @if($rental->user->phone)
                                                <a href="tel:{{ $rental->user->phone }}" class="text-decoration-none">
                                                    {{ $rental->user->phone }}
                                                </a>
                                            @else
                                                <span class="text-muted">Not provided</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            @else
                                <p class="text-muted">User information not available</p>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <!-- Rental Timeline -->
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase mb-3">Rental Period</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td class="border-0"><strong>Start Date:</strong></td>
                                    <td class="border-0">{{ $rental->start_date->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="border-0"><strong>End Date:</strong></td>
                                    <td class="border-0">{{ $rental->end_date->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="border-0"><strong>Days:</strong></td>
                                    <td class="border-0">{{ $rental->days ?? 0 }} days</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Rental Pricing -->
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase mb-3">Pricing & Cost</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td class="border-0"><strong>Daily Rate:</strong></td>
                                    <td class="border-0">₱{{ number_format($rental->vehicle->price_per_day ?? 0, 2) }}/day</td>
                                </tr>
                                <tr>
                                    <td class="border-0"><strong>Total Price:</strong></td>
                                    <td class="border-0"><strong class="text-success">₱{{ number_format($rental->total_price, 2) }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Location Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase mb-2">Pickup Location</h6>
                            <p class="mb-0">{{ $rental->pickup_location ?? 'Not specified' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase mb-2">Dropoff Location</h6>
                            <p class="mb-0">{{ $rental->dropoff_location ?? 'Not specified' }}</p>
                        </div>
                    </div>

                    @if($rental->notes)
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase mb-2">Notes</h6>
                            <div class="alert alert-light border">
                                {{ $rental->notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Status Update Card -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-toggle2-on me-2"></i>Update Rental Status</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h6 class="mb-3">Current Status</h6>
                            <span class="badge bg-{{ $rental->status === 'completed' ? 'success' : ($rental->status === 'ongoing' ? 'warning' : ($rental->status === 'confirmed' ? 'info' : ($rental->status === 'pending' ? 'secondary' : 'danger'))) }} fs-6 p-3">
                                {{ ucfirst($rental->status) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('admin.rentals.updateStatus', $rental) }}" class="d-flex gap-2">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm" required>
                                    <option value="">Change Status To...</option>
                                    <option value="pending" {{ $rental->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $rental->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="ongoing" {{ $rental->status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="completed" {{ $rental->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $rental->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-info btn-sm">
                                    <i class="bi bi-check-circle me-1"></i>Update
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
