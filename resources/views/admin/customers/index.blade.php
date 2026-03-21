@extends('layouts.app')

@section('title', 'Customer Management')

@section('content')
<div class="container-fluid py-4">
<div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-0"><i class="bi bi-people me-2"></i>Customer Management</h1>
            <p class="text-muted mb-0 mt-1">Full CRUD: Create, read, update, delete customers</p>
        </div>
        <div>
            <span class="badge bg-info fs-6">Total: {{ \App\Models\Customer::count() }}</span>
            <a href="{{ route('admin.customers.create') }}" class="btn btn-primary btn-sm ms-2">
                <i class="bi bi-plus-lg me-1"></i>New Customer
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

    <div class="card shadow-lg border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Rentals</th>
                            <th>Loyalty Points</th>
                            <th>Joined</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr class="align-middle">
                                <td class="ps-4">
                                    <div class="fw-bold">{{ $customer->name }}</div>
                                </td>
                                <td>
                                    <a href="mailto:{{ $customer->email }}" class="text-decoration-none">
                                        {{ $customer->email }}
                                    </a>
                                </td>
                                <td>
                                    <a href="tel:{{ $customer->phone }}" class="text-decoration-none">
                                        {{ $customer->phone ?? 'N/A' }}
                                    </a>
                                </td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $customer->rentals_count }}
                                </span>
                            </td>
                                <td>
                                    <span class="fw-semibold text-success">
                                        {{ $customer->loyalty_points ?? 0 }} pts
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $customer->created_at->format('M d, Y') }}
                                    </small>
                                </td>
                                    <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" class="d-inline" onsubmit="return confirm('Delete {{ $customer->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-3 mb-0">No customers found yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($customers->hasPages())
            <div class="card-footer bg-light">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
