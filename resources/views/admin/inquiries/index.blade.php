@extends('layouts.app')

@section('title', 'Inquiry Management')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-0"><i class="bi bi-chat-left-dots me-2"></i>Inquiry Management</h1>
            <p class="text-muted mb-0 mt-1">View and manage all vehicle inquiries</p>
        </div>
        <div>
            <span class="badge bg-warning fs-6">{{ \App\Models\Inquiry::where('status', 'pending')->count() }} Pending</span>
            <span class="badge bg-info fs-6 ms-2">{{ \App\Models\Inquiry::count() }} Total</span>
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
            <form method="GET" action="{{ route('admin.inquiries.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small">Filter by Status</label>
                    <select class="form-select form-select-sm" name="status" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="responded" {{ request('status') == 'responded' ? 'selected' : '' }}>Responded</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                @if(request('status'))
                    <div class="col-md-3 d-flex align-items-end">
                        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-secondary w-100">
                            <i class="bi bi-x-circle me-1"></i>Clear Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Vehicle</th>
                            <th>Customer</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inquiries as $inquiry)
                            <tr class="align-middle">
                                <td class="ps-4">
                                    <div class="fw-bold">{{ $inquiry->vehicle->year }} {{ $inquiry->vehicle->make }} {{ $inquiry->vehicle->model }}</div>
                                    <small class="text-muted">{{ $inquiry->vehicle->plate_number }}</small>
                                </td>
                                <td>
                                    @if($inquiry->user)
                                        <div class="fw-bold">{{ $inquiry->user->name }}</div>
                                        <small class="text-muted">{{ $inquiry->user->email }}</small>
                                    @else
                                        <span class="text-muted">Unknown User</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ ucfirst($inquiry->type) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $inquiry->status === 'responded' ? 'success' : ($inquiry->status === 'closed' ? 'secondary' : ($inquiry->status === 'pending' ? 'warning' : 'danger')) }}">
                                        {{ ucfirst($inquiry->status) }}
                                    </span>
                                </td>
                                <td>
                                    <small>{{ $inquiry->created_at->format('M d, Y') }}</small>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-outline-info" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-chat-left-x text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-3 mb-0">No inquiries found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($inquiries->hasPages())
            <div class="card-footer bg-light">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
