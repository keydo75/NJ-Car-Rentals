    @extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div style="background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%); border-radius: 12px; padding: 40px; color: white;">
                <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">
                    <i class="bi bi-speedometer2"></i> Welcome, {{ $admin->name }}!
                </h1>
                <p style="font-size: 1.1rem; color: rgba(255,255,255,0.9);">
                    Here's a snapshot of your business activity.
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-5">
        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: #1a1a1a; border: 1px solid #333;">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-subtitle mb-2 text-muted text-uppercase">Revenue (Last 30 Days)</h6>
                    <h2 class="card-title" style="color: #2ecc71; font-weight: 700;">₱{{ number_format($stats['revenue_last_30_days'], 2) }}</h2>
                    <a href="{{ route('admin.reports.index') }}" class="card-link small mt-auto">View Reports</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: #1a1a1a; border: 1px solid #333;">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-subtitle mb-2 text-muted text-uppercase">Rentals (Last 30 Days)</h6>
                    <h2 class="card-title" style="color: #3498db; font-weight: 700;">{{ $stats['rentals_last_30_days'] }}</h2>
                    <a href="{{ route('admin.rentals.index') }}" class="card-link small mt-auto">Manage Rentals</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: #1a1a1a; border: 1px solid #333;">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-subtitle mb-2 text-muted text-uppercase">Customers</h6>
                    <h2 class="card-title" style="color: #f39c12; font-weight: 700;">{{ \App\Models\Customer::count() }}</h2>
                    <a href="{{ route('admin.customers.index') }}" class="card-link small mt-auto">Manage Customers</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: #1a1a1a; border: 1px solid #333;">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-subtitle mb-2 text-muted text-uppercase">Messages <span id="adminChatBadge" class="badge bg-danger rounded-pill ms-1" style="font-size: 0.7rem;"></span></h6>
                    <h2 class="card-title" style="color: #f39c12; font-weight: 700;" id="adminUnreadCount">0</h2>
                    <a href="{{ route('admin.chat') }}" class="card-link small mt-auto">View Chat</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: #1a1a1a; border: 1px solid #333;">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-subtitle mb-2 text-muted text-uppercase">Available Vehicles</h6>
                    <h2 class="card-title" style="color: #9b59b6; font-weight: 700;">{{ $stats['available_vehicles'] }}</h2>
                    <a href="{{ route('admin.vehicles.index') }}" class="card-link small mt-auto">Manage Vehicles</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card text-white h-100" style="background-color: #1a1a1a; border: 1px solid #333;">
                <div class="card-body">
                    <h5 class="card-title">Rentals in Last 7 Days</h5>
                    <canvas id="rentalsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5 mb-4">
            <div class="card text-white h-100" style="background-color: #1a1a1a; border: 1px solid #333;">
                <div class="card-body">
                    <h5 class="card-title">Recent Rentals</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-borderless table-sm">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Vehicle</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentRentals as $rental)
                                    <tr>
                                        <td>{{ $rental->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $rental->vehicle->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge rounded-pill 
                                                @if($rental->status == 'completed') bg-success 
                                                @elseif($rental->status == 'active') bg-primary
                                                @elseif($rental->status == 'pending') bg-warning text-dark
                                                @else bg-secondary @endif">
                                                {{ ucfirst($rental->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">No recent rentals.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('rentalsChart').getContext('2d');
        const rentalsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($charts['rentals']['labels']),
                datasets: [{
                    label: 'New Rentals',
                    data: @json($charts['rentals']['data']),
                    backgroundColor: 'rgba(0, 102, 204, 0.6)',
                    borderColor: '#0066cc',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, ticks: { color: '#909090', stepSize: 1 }, grid: { color: 'rgba(255, 255, 255, 0.1)' } },
                    x: { ticks: { color: '#909090' }, grid: { display: false } }
                },
                plugins: { legend: { display: false } }
            }
        });

        // Load chat unread count (with fallback)
        fetch('/admin/chat/unread-count')
            .then(response => response.json())
            .then(data => {
                document.getElementById('adminUnreadCount').textContent = data.unread;
                const badge = document.getElementById('adminChatBadge');
                if (data.unread > 0) {
                    badge.textContent = data.unread;
                    badge.style.display = 'inline';
                } else {
                    badge.style.display = 'none';
                }
            });
    });
</script>
@endpush
