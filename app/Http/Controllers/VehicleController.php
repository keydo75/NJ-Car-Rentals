<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::where('status', 'available');

        // Search by make, model, or plate number
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('make', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('plate_number', 'like', "%{$search}%");
            });
        }

        // Filter by max price
        if ($request->filled('max_price')) {
            $maxPrice = $request->max_price;
            $query->where(function ($q) use ($maxPrice) {
                $q->where(function ($subQ) use ($maxPrice) {
                    $subQ->where('type', 'rental')
                         ->where('price_per_day', '<=', $maxPrice);
                })->orWhere(function ($subQ) use ($maxPrice) {
                    $subQ->where('type', 'sale')
                         ->where('sale_price', '<=', $maxPrice);
                });
            });
        }

        $vehicles = $query->paginate(12);
        return view('vehicles.index', compact('vehicles'));
    }
    
    public function rental(Request $request)
    {
        $query = Vehicle::where('type', 'rental')
                       ->where('status', 'available');

        // Search by make, model, or plate number
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('make', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('plate_number', 'like', "%{$search}%");
            });
        }

        // Filter by max price
        if ($request->filled('max_price')) {
            $maxPrice = $request->max_price;
            $query->where('price_per_day', '<=', $maxPrice);
        }

$vehicles = $query->with(['rentals' => function($q) {
            $q->whereIn('status', ['pending', 'confirmed', 'ongoing'])
              ->where('end_date', '>=', now())
              ->orderBy('end_date', 'asc');
        }])->paginate(12);
        
        $vehicles->getCollection()->each(function ($vehicle) {
            $active = $vehicle->rentals->first();
            $vehicle->rented_until = $active ? $active->end_date->format('M d, Y') : null;
            $vehicle->rental_status = $active ? $active->status : null;
        });
        
        $featuredRentals = Vehicle::where('type', 'rental')
                                 ->whereDoesntHave('activeRental')
                                 ->limit(9)
                                 ->get();
        
        return view('vehicles.rental', compact('vehicles', 'featuredRentals'));
    }
    
    public function sale(Request $request)
    {
        $query = Vehicle::where('type', 'sale')
                       ->where('status', 'available');

        // Search by make, model, or plate number
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('make', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('plate_number', 'like', "%{$search}%");
            });
        }
        
        // Apply filters
        if ($request->filled('brand')) {
            $query->where('make', $request->brand);
        }

        if ($request->filled('price_range')) {
            $range = $request->price_range;
            if ($range === '0-100000') {
                $query->where('sale_price', '<=', 100000);
            } elseif ($range === '100000-500000') {
                $query->whereBetween('sale_price', [100000, 500000]);
            } elseif ($range === '500000-1000000') {
                $query->whereBetween('sale_price', [500000, 1000000]);
            } elseif ($range === '1000000+') {
                $query->where('sale_price', '>=', 1000000);
            }
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Filter by max price (from homepage search)
        if ($request->filled('max_price')) {
            $maxPrice = (int)$request->max_price;
            // Only filter if max_price is a reasonable value (prevent filtering all results)
            if ($maxPrice > 0) {
                $query->where('sale_price', '<=', $maxPrice);
            }
        }
        
        $vehicles = $query->paginate(12);
        
        // Get unique brands (makes) for filter dropdown
        $brands = Vehicle::where('type', 'sale')
                        ->where('status', 'available')
                        ->distinct()
                        ->pluck('make')
                        ->sort()
                        ->values();
        
        return view('vehicles.sale', compact('vehicles', 'brands'));
    }
    
    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        
        // Get all booked date ranges for this vehicle
        // Block dates for: confirmed, ongoing, and pending bookings
        // (pending bookings should also block dates as they await admin approval)
        $bookedRanges = $vehicle->rentals()
            ->whereIn('status', ['confirmed', 'ongoing', 'pending'])
            ->get(['start_date', 'end_date'])
            ->map(function($rental) {
                return [
                    'start' => $rental->start_date->toDateString(),
                    'end' => $rental->end_date->toDateString(),
                ];
            })
            ->toArray();
            
        return view('vehicles.show', compact('vehicle', 'bookedRanges'));
    }

    /**
     * Upload and attach an image file to the vehicle (stores file and saves path to DB)
     */
    public function uploadImage(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $request->validate([
            'image' => 'required|image|max:4096', // max 4MB
        ]);

        $path = $request->file('image')->store('images/vehicles', 'public');

        // Save path compatible with getImageUrl() which prefers image_path
        $vehicle->image_path = 'storage/' . $path;
        $vehicle->save();

        return back()->with('success', 'Vehicle image uploaded successfully.');
    }
}