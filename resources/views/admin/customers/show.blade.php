@extends('layouts.app')

@section('title', 'Customer Details - ' . $customer->name)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Customer Details Card -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-primary-gradient text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-person-circle me-2"></i>Customer Details</h4>
                    <div>
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left me-1"></i>Back to Customers
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase mb-2">Personal Information</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td class="border-0"><strong>Name:</strong></td>
                                    <td class="border-0">{{ $customer->name }}</td>
                                </tr>
                                <tr>
                                    <td class="border-0"><strong>Email:</strong></td>
                                    <td class="border-0">
                                        <a href="mailto:{{ $customer->email }}" class="text-decoration-none">
                                            {{ $customer->email }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0"><strong>Phone:</strong></td>
                                    <td class="border-0">
                                        @if($customer->phone)
                                            <a href="tel:{{ $customer->phone }}" class="text-decoration-none">
                                                {{ $customer->phone }}
                                            </a>
                                        @else
                                            <span class="text-muted">Not provided</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0"><strong>Address:</strong></td>
                                    <td class="border-0">{{ $customer->address ?? 'Not provided' }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase mb-2">Account Information</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td class="border-0"><strong>Member Since:</strong></td>
                                    <td class="border-0">{{ $customer->created_at->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="border-0"><strong>Last Updated:</strong></td>
                                    <td class="border-0">{{ $customer->updated_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="border-0"><strong>Loyalty Points:</strong></td>
                                    <td class="border-0">
                                        <span class="badge bg-success fs-6">{{ $customer->loyalty_points ?? 0 }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0"><strong>Total Rentals:</strong></td>
                                    <td class="border-0">
                                        <span class="badge bg-info fs-6">{{ $customer->rentals_count }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0"><strong>Actions:</strong></td>
                                    <td class="border-0">
                                        <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" class="d-inline" onsubmit="return confirm('Delete {{ $customer->name }}? This is permanent.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rental History -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Rental History</h5>
                </div>
                <div class="card-body p-0">
                    @if($rentals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Vehicle</th>
                                        <th>Status</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Total Cost</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rentals as $rental)
                                        <tr class="align-middle">
                                            <td class="ps-4">
                                                <strong>{{ $rental->vehicle->year }} {{ $rental->vehicle->make }} {{ $rental->vehicle->model }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $rental->vehicle->plate_number }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $rental->status === 'completed' ? 'success' : ($rental->status === 'active' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($rental->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ $rental->start_date->format('M d, Y') }}</small>
                                            </td>
                                            <td>
                                                <small>{{ $rental->end_date->format('M d, Y') }}</small>
                                            </td>
                                            <td>
                                                <strong class="text-success">₱{{ number_format($rental->total_cost ?? 0, 2) }}</strong>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="#" class="btn btn-sm btn-outline-info" title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($rentals->hasPages())
                            <div class="card-footer bg-light">
                                {{ $rentals->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3 mb-0">No rental history yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Inquiries -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="bi bi-chat-left-text me-2"></i>Vehicle Inquiries</h5>
                </div>
                <div class="card-body p-0">
                    @if($inquiries->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Vehicle</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inquiries as $inquiry)
                                        <tr class="align-middle">
                                            <td class="ps-4">
                                                <strong>{{ $inquiry->vehicle->year }} {{ $inquiry->vehicle->make }} {{ $inquiry->vehicle->model }}</strong>
                                            </td>
                                            <td>
                                                <small>{{ Str::limit($inquiry->message, 50) }}</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $inquiry->created_at->format('M d, Y') }}</small>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="#" class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($inquiries->hasPages())
                            <div class="card-footer bg-light">
                                {{ $inquiries->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-chat-left-dots text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3 mb-0">No inquiries yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
