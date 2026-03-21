<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Notifications\BookingConfirmedNotification;
use Illuminate\Http\Request;

class RentalController extends Controller
{
public function index(Request $request)
    {
        $query = Rental::with(['vehicle', 'user'])->latest();
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->type) {
            $query->whereHas('vehicle', function($q) use ($request) {
                $q->where('type', $request->type);
            });
        }
        
        if ($request->sort) {
            if ($request->sort === 'oldest') {
                $query->oldest();
            }
        }
        
        $rentals = $query->paginate(15);
        $rentals->appends($request->query());
        
        return view('admin.rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        $rental->load(['vehicle', 'user']);
        return view('admin.rentals.show', compact('rental'));
    }

    public function updateStatus(Request $request, Rental $rental)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,ongoing,completed,cancelled',
        ]);

        $oldStatus = $rental->status;
        $rental->update(['status' => $request->status]);

        // Send confirmation notification when booking is confirmed
        if ($request->status === 'confirmed' && $oldStatus !== 'confirmed') {
            $rental->user->notify(new BookingConfirmedNotification($rental));
        }

        return redirect()->route('admin.rentals.show', $rental)->with('success', 'Rental status updated successfully.');
    }
}
