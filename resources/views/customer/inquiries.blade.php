@extends('layouts.app')

@section('title', 'My Inquiries')

@section('content')
<div class="container py-5">
    <h1 class="display-5 fw-bold mb-4">My Inquiries</h1>
    <p class="lead text-muted mb-4">View and manage your vehicle inquiries below.</p>
    @if($inquiries->count())
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Vehicle</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Submitted Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inquiries as $inquiry)
                        <tr>
                            <td>{{ $inquiry->vehicle->make ?? 'N/A' }} {{ $inquiry->vehicle->model ?? '' }}</td>
                            <td><span class="badge bg-info">{{ ucfirst($inquiry->type) }}</span></td>
                            <td>
                                @if($inquiry->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($inquiry->status === 'responded')
                                    <span class="badge bg-success">Responded</span>
                                @elseif($inquiry->status === 'closed')
                                    <span class="badge bg-secondary">Closed</span>
                                @else
                                    <span class="badge bg-danger">{{ ucfirst($inquiry->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $inquiry->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('vehicles.show', $inquiry->vehicle_id) }}" class="btn btn-sm btn-outline-primary">View Vehicle</a>
                                @if(in_array($inquiry->status, ['pending', 'responded']))
                                    <form method="POST" action="{{ route('customer.inquiries.cancel', $inquiry->id) }}" style="display:inline-block; margin-left:4px;" onsubmit="return confirm('Are you sure you want to cancel this inquiry?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card shadow-lg border-0">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                <h5 class="text-muted mb-3">No Inquiries Yet</h5>
                <p class="text-muted mb-4">Start exploring our vehicles and submit your first inquiry today!</p>
                <a href="{{ route('vehicles.sale') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle me-2"></i> Browse Vehicles
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
