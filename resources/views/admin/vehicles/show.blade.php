@extends('layouts.app')

@section('title', 'View Vehicle')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary-gradient text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-eye me-2"></i>Vehicle Details</h4>
                    <div>
                        <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-light btn-sm">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left me-1"></i>Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            @if($vehicle->image_path)
                                <img src="{{ asset($vehicle->image_path) }}" alt="{{ $vehicle->name }}" class="img-fluid rounded shadow">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <i class="bi bi-car-front text-muted" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <h3 class="mb-1">{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</h3>
                                    <p class="text-muted mb-2">{{ $vehicle->plate_number }}</p>
                                    <div class="mb-2">
                                        <span class="badge bg-{{ $vehicle->type === 'rental' ? 'info' : 'success' }} fs-6">
                                            {{ ucfirst($vehicle->type) }}
                                        </span>
                                        <span class="badge bg-{{ $vehicle->status === 'available' ? 'success' : 'warning' }} fs-6 ms-1">
                                            {{ ucfirst($vehicle->status) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3 text-end">
                                    <div class="h4 mb-0 text-primary">
                                        @if($vehicle->type === 'rental')
                                            ₱{{ number_format($vehicle->price_per_day, 2) }}
                                            <small class="text-muted">/day</small>
                                        @else
                                            ₱{{ number_format($vehicle->sale_price, 2) }}
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="border-0"><strong>Transmission:</strong></td>
                                            <td class="border-0">{{ ucfirst($vehicle->transmission) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border-0"><strong>Seats:</strong></td>
                                            <td class="border-0">{{ $vehicle->seats }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border-0"><strong>Fuel Type:</strong></td>
                                            <td class="border-0">{{ ucfirst($vehicle->fuel_type) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border-0"><strong>GPS:</strong></td>
                                            <td class="border-0">
                                                @if($vehicle->has_gps)
                                                    <i class="bi bi-check-circle text-success"></i> Has GPS
                                                    @if($vehicle->gps_enabled)
                                                        (Enabled)
                                                    @else
                                                        (Disabled)
                                                    @endif
                                                @else
                                                    <i class="bi bi-x-circle text-muted"></i> No GPS
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-sm-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="border-0"><strong>Created:</strong></td>
                                            <td class="border-0">{{ $vehicle->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border-0"><strong>Updated:</strong></td>
                                            <td class="border-0">{{ $vehicle->updated_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        @if($vehicle->trashed())
                                            <tr>
                                                <td class="border-0"><strong>Deleted:</strong></td>
                                                <td class="border-0 text-danger">{{ $vehicle->deleted_at->format('M d, Y H:i') }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($vehicle->features && is_array($vehicle->features) && count($vehicle->features) > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Features</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($vehicle->features as $feature)
                                        <span class="badge bg-light text-primary border">{{ trim($feature) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($vehicle->description)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Description</h5>
                                <p class="mb-0">{{ $vehicle->description }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if($vehicle->trashed())
                                        <span class="text-danger">
                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                            This vehicle has been deleted
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    @if(!$vehicle->trashed())
                                        <form method="POST" action="{{ route('admin.vehicles.destroy', $vehicle) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this vehicle?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash me-1"></i>Delete Vehicle
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.vehicles.restore', $vehicle) }}" class="d-inline me-2">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.vehicles.force-delete', $vehicle) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to permanently delete this vehicle? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-x-circle me-1"></i>Force Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection