@extends('layouts.app')

@section('title', 'Admin Reports')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div style="background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%); border-radius: 12px; padding: 40px; color: white;">
                <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">
                    <i class="bi bi-graph-up"></i> Business Reports
                </h1>
                <p style="font-size: 1.1rem; color: rgba(255,255,255,0.9);">
                    An overview of rentals, revenue, and vehicle status.
                </p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div style="background: #1a1a1a; border: 1px solid #333; border-radius: 12px; padding: 25px;">
                <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label style="display: block; margin-bottom: 8px; color: #fff; font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">
                            <i class="bi bi-calendar-range me-2"></i>Time Period
                        </label>
                        <select name="period" class="form-select" style="background: #2a2a2a; border-color: #444; color: white; padding: 12px 15px;" onchange="this.form.submit()">
                            <option value="last_7_days" @if($stats['period'] == 'last_7_days') selected @endif>Last 7 Days</option>
                            <option value="last_30_days" @if($stats['period'] == 'last_30_days') selected @endif>Last 30 Days</option>
                            <option value="last_90_days" @if($stats['period'] == 'last_90_days') selected @endif>Last 90 Days</option>
                            <option value="all_time" @if($stats['period'] == 'all_time') selected @endif>All Time</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-5">
        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: #1a1a1a; border: 1px solid #333;">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted text-uppercase">Total Revenue</h6>
                    <h2 class="card-title" style="color: #2ecc71; font-weight: 700;">₱{{ number_format($stats['total_revenue'], 2) }}</h2>
                    <p class="card-text small">From completed rentals in the selected period.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: #1a1a1a; border: 1px solid #333;">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted text-uppercase">Total Rentals</h6>
                    <h2 class="card-title" style="color: #3498db; font-weight: 700;">{{ $stats['total_rentals'] }}</h2>
                    <p class="card-text small">Bookings created in the selected period.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: #1a1a1a; border: 1px solid #333;">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted text-uppercase">Pending Bookings</h6>
                    <h2 class="card-title" style="color: #f39c12; font-weight: 700;">{{ $stats['pending_rentals'] }}</h2>
                    <p class="card-text small">Total bookings awaiting confirmation.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: #1a1a1a; border: 1px solid #333;">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted text-uppercase">Available Vehicles</h6>
                    <h2 class="card-title" style="color: #9b59b6; font-weight: 700;">{{ $stats['available_vehicles'] }}</h2>
                    <p class="card-text small">Vehicles ready for rent or sale now.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <div class="col-12">
            <div class="card text-white" style="background-color: #1a1a1a; border: 1px solid #333;">
                <div class="card-body">
                    <h5 class="card-title">New Rentals (Last 30 Days)</h5>
                    <canvas id="rentalsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%236c757d' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('rentalsChart').getContext('2d');
        const rentalsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($charts['rentals']['labels']),
                datasets: [{
                    label: 'New Rentals',
                    data: @json($charts['rentals']['data']),
                    backgroundColor: 'rgba(0, 102, 204, 0.2)',
                    borderColor: '#0066cc',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, ticks: { color: '#909090', stepSize: 1 }, grid: { color: '#333' } },
                    x: { ticks: { color: '#909090' }, grid: { color: '#333' } }
                },
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
@endpush