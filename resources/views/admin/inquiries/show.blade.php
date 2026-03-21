@extends('layouts.app')

@section('title', 'Inquiry Details')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8">
            <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left me-2"></i>Back to Inquiries
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Inquiry Details -->
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Inquiry Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Vehicle</label>
                            <p class="h6 mb-0">
                                {{ $inquiry->vehicle->year }} {{ $inquiry->vehicle->make }} {{ $inquiry->vehicle->model }}
                                <br>
                                <small class="text-muted">{{ $inquiry->vehicle->plate_number }}</small>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Inquiry Type</label>
                            <p class="h6 mb-0">
                                <span class="badge bg-light text-dark">{{ ucfirst($inquiry->type) }}</span>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Customer Name</label>
                            <p class="h6 mb-0">
                                @if($inquiry->user)
                                    <a href="{{ route('admin.customers.show', $inquiry->user) }}">{{ $inquiry->user->name }}</a>
                                @else
                                    {{ $inquiry->name }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Email</label>
                            <p class="h6 mb-0"><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Phone</label>
                            <p class="h6 mb-0"><a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Submitted</label>
                            <p class="h6 mb-0">{{ $inquiry->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="text-muted small">Message</label>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0">{{ $inquiry->message }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Update -->
        <div class="col-lg-4">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="bi bi-sliders me-2"></i>Update Status</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.inquiries.updateStatus', $inquiry) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status" class="form-label">Current Status</label>
                            <p class="h5 mb-3">
                                <span class="badge bg-{{ $inquiry->status === 'responded' ? 'success' : ($inquiry->status === 'closed' ? 'secondary' : ($inquiry->status === 'pending' ? 'warning' : 'danger')) }} fs-6">
                                    {{ ucfirst($inquiry->status) }}
                                </span>
                            </p>

                            <label for="status" class="form-label">Change To</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="">-- Select Status --</option>
                                <option value="pending" {{ $inquiry->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="responded" {{ $inquiry->status === 'responded' ? 'selected' : '' }}>Responded</option>
                                <option value="closed" {{ $inquiry->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="cancelled" {{ $inquiry->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle me-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Card -->
            <div class="card shadow-lg border-0 mt-3">
                <div class="card-body text-center">
                    <h6 class="mb-3">Quick Actions</h6>
                    <a href="mailto:{{ $inquiry->email }}" class="btn btn-outline-primary btn-sm w-100 mb-2">
                        <i class="bi bi-envelope me-2"></i>Send Email
                    </a>
                    <a href="tel:{{ $inquiry->phone }}" class="btn btn-outline-success btn-sm w-100">
                        <i class="bi bi-telephone me-2"></i>Call Customer
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
