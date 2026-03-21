@extends('layouts.app')

@section('title', 'Rental Management')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-0"><i class="bi bi-calendar-check me-2"></i>Rental Management</h1>
            <p class="text-muted mb-0 mt-1">View and manage all vehicle rentals</p>
        </div>
        <div>
            <span class="badge bg-warning fs-6">{{ \App\Models\Rental::where('status', 'ongoing')->count() }} Active</span>
            <span class="badge bg-info fs-6 ms-2">{{ \App\Models\Rental::count() }} Total</span>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Card -->
    <div class="card shadow-lg border-0 mb-4">
<div class="card-body p-3">
            <form method="GET" action="{{ route('admin.rentals.index') }}" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label small">Status</label>
                    <select class="form-select form-select-sm" name="status" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Vehicle Type</label>
                    <select class="form-select form-select-sm" name="type" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="rental" {{ request('type') == 'rental' ? 'selected' : '' }}>Rental</option>
                        <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>Sale</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Sort</label>
                    <select class="form-select form-select-sm" name="sort" onchange="this.form.submit()">
                        <option value="newest">Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    </select>
                </div>
                @if(request()->hasAny(['status', 'type', 'sort']))
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="{{ route('admin.rentals.index') }}" class="btn btn-sm btn-outline-secondary w-100">
                            <i class="bi bi-x-circle me-1"></i>Clear All
                        </a>
                    </div>
                @endif
                <div class="col-md-4 d-flex align-items-end">
                    <input type="text" class="form-control form-control-sm" name="search" placeholder="Search rentals..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary btn-sm ms-1">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
<table class="table table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="min-width: 200px;">Vehicle</th>
                            <th style="min-width: 150px;">Customer</th>
                            <th style="min-width: 100px;">Status</th>
                            <th style="min-width: 100px;">Start</th>
                            <th style="min-width: 100px;">End</th>
                            <th style="min-width: 120px;">Price</th>
                            <th class="text-end pe-4" style="min-width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rentals as $rental)
                            <tr class="align-middle">
                                <td class="ps-4">
                                    <div class="fw-bold">{{ $rental->vehicle->year }} {{ $rental->vehicle->make }} {{ $rental->vehicle->model }}</div>
                                    <small class="text-muted">{{ $rental->vehicle->plate_number }}</small>
                                </td>
                                <td>
                                    @if($rental->user)
                                        <div class="fw-bold">{{ $rental->user->name }}</div>
                                        <small class="text-muted">{{ $rental->user->email }}</small>
                                    @else
                                        <span class="text-muted">Unknown User</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $rental->status === 'completed' ? 'success' : ($rental->status === 'ongoing' ? 'warning' : ($rental->status === 'confirmed' ? 'info' : ($rental->status === 'pending' ? 'secondary' : 'danger'))) }}">
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
                                    <strong class="text-success">₱{{ number_format($rental->total_price, 2) }}</strong>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.rentals.show', $rental) }}" class="btn btn-outline-info" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-3 mb-0">No rentals found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($rentals->hasPages())
            <div class="card-footer bg-light">
                {{ $rentals->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
