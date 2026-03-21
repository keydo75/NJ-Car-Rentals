@extends('layouts.app')

@section('title', 'Vehicle Management')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-0"><i class="bi bi-car-front me-2"></i>Vehicle Management</h1>
            <p class="text-muted mb-0 mt-1">Manage your rental and sales inventory</p>
        </div>
        <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle me-2"></i>Add New Vehicle
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-lg border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Vehicle</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Pricing</th>
                            <th>Year</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicles as $vehicle)
                            <tr class="align-middle {{ $vehicle->trashed() ? 'table-secondary' : '' }}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($vehicle->image_path)
                                            <img src="{{ asset($vehicle->image_path) }}" alt="{{ $vehicle->name }}" class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="bi bi-car-front text-muted fs-5"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</div>
                                            <div class="small text-muted">{{ $vehicle->plate_number }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $vehicle->type === 'rental' ? 'info' : 'success' }}">
                                        {{ ucfirst($vehicle->type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $vehicle->status === 'available' ? 'success' : 'warning' }}">
                                        {{ ucfirst($vehicle->status) }}
                                    </span>
                                    @if($vehicle->trashed())
                                        <span class="badge bg-danger ms-1">Deleted</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">
                                        @if($vehicle->type === 'rental')
                                            ₱{{ number_format($vehicle->price_per_day, 2) }}<span class="text-muted fw-normal">/day</span>
                                        @else
                                            ₱{{ number_format($vehicle->sale_price, 2) }}
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $vehicle->year }}</td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.vehicles.show', $vehicle) }}" class="btn btn-outline-info" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(!$vehicle->trashed())
                                            <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete('{{ route('admin.vehicles.destroy', $vehicle) }}')" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @else
                                            <form method="POST" action="{{ route('admin.vehicles.restore', $vehicle) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success btn-sm" title="Restore">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmForceDelete('{{ route('admin.vehicles.force-delete', $vehicle) }}')" title="Permanently Delete">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-car-front text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-3 mb-0">No vehicles found. <a href="{{ route('admin.vehicles.create') }}">Create one now</a></p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($vehicles->hasPages())
            <div class="card-footer bg-light">
                {{ $vehicles->links() }}
            </div>
        @endif
    </div>
</div>

<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmDelete(url) {
    if (confirm('Are you sure you want to delete this vehicle? This action can be reversed.')) {
        const form = document.getElementById('deleteForm');
        form.action = url;
        form.submit();
    }
}

function confirmForceDelete(url) {
    if (confirm('Are you sure you want to permanently delete this vehicle? This action cannot be reversed.')) {
        const form = document.getElementById('deleteForm');
        form.action = url;
        form.submit();
    }
}
</script>

@endsection