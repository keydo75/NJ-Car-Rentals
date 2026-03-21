<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'pickup_lat' => 'nullable|numeric',
            'pickup_lon' => 'nullable|numeric',
            'dropoff_lat' => 'nullable|numeric',
            'dropoff_lon' => 'nullable|numeric',
            'addons' => 'nullable|array',
            'addons.*' => 'string|in:additional_driver,child_seat',
            'terms_accepted' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        if ($vehicle->status !== 'available') {
            return back()->with('error', 'This vehicle is not available for rent.');
        }

        $start = \Carbon\Carbon::parse($request->start_date)->startOfDay();
        $end = \Carbon\Carbon::parse($request->end_date)->startOfDay();
        
        // Check for date overlap with existing bookings
        // Only check against confirmed, ongoing, and pending bookings
        $conflictingRental = \App\Models\Rental::where('vehicle_id', $vehicle->id)
            ->whereIn('status', ['confirmed', 'ongoing', 'pending'])
            ->where(function ($query) use ($start, $end) {
                 // Check if new booking overlaps with existing booking
                // Overlap occurs when: (new_start <= existing_end) AND (new_end >= existing_start)
                $query->where(function ($q) use ($start, $end) {
                    $q->where('start_date', '<=', $end->toDateString())
                      ->where('end_date', '>=', $start->toDateString());
                });
            })
            ->first();
            
        if ($conflictingRental) {
            return back()->with('error', 'This vehicle is already booked for the selected dates. Please choose different dates.')->withInput();
        }
        
        // Calculate days using timestamps
        $seconds = $end->getTimestamp() - $start->getTimestamp();
        $days = (int) floor(abs($seconds) / 86400) + 1;
        
        if ($days < 1) {
            return back()->with('error', 'Invalid rental period.');
        }

        // Calculate base price
        $pricePerDay = $vehicle->price_per_day;
        $vehicleSubtotal = $pricePerDay * $days;

        // Calculate add-ons price
        $selectedAddons = $request->input('addons', []);
        $addonsPrice = 0;
        $addonsDetails = [];
        
        foreach ($selectedAddons as $addonKey) {
            if (isset(Rental::$addonOptions[$addonKey])) {
                $addon = Rental::$addonOptions[$addonKey];
                // All add-ons are flat rate
                $addonPrice = $addon['price'];
                $addonsPrice += $addonPrice;
                $addonsDetails[$addonKey] = [
                    'name' => $addon['name'],
                    'price' => $addonPrice,
                    'quantity' => 1,
                ];
            }
        }

        $subtotal = $vehicleSubtotal + $addonsPrice;
        $taxRate = 0.12;
        $taxAmount = round($subtotal * $taxRate, 2);
        $totalPrice = round($subtotal + $taxAmount, 2);

        try {
            $rental = Rental::create([
                'user_id' => auth()->guard('customer')->id(),
                'vehicle_id' => $vehicle->id,
                'start_date' => $start->toDateString(),
                'end_date' => $end->toDateString(),
                'days' => $days,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'pickup_location' => $request->pickup_location,
                'dropoff_location' => $request->dropoff_location,
                'pickup_lat' => $request->input('pickup_lat'),
                'pickup_lon' => $request->input('pickup_lon'),
                'dropoff_lat' => $request->input('dropoff_lat'),
                'dropoff_lon' => $request->input('dropoff_lon'),
                'notes' => $request->notes,
                'addons' => $addonsDetails,
                'addons_price' => $addonsPrice,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'terms_accepted' => true,
                'terms_accepted_at' => now(),
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Rental create failed', ['exception' => $e]);
            return back()->with('error', 'Failed to create booking; please try again.');
        }

        \Illuminate\Support\Facades\Log::info('Rental created', [
            'rental_id' => $rental->id, 
            'user_id' => $rental->user_id, 
            'vehicle_id' => $rental->vehicle_id, 
            'start' => $rental->start_date, 
            'end' => $rental->end_date,
            'total' => $rental->total_price,
            'addons' => $rental->addons,
        ]);

        return redirect()->route('customer.bookings')->with('success', 'Your booking was created successfully! Booking ID: #' . str_pad($rental->id, 6, '0', STR_PAD_LEFT) . '. Our team will contact you shortly.');
    }
    
    /**
     * Calculate price estimation (for AJAX)
     */
    public function calculatePrice(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'addons' => 'nullable|array',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        
        $start = \Carbon\Carbon::parse($request->start_date)->startOfDay();
        $end = \Carbon\Carbon::parse($request->end_date)->startOfDay();
        $seconds = $end->getTimestamp() - $start->getTimestamp();
        $days = (int) floor(abs($seconds) / 86400) + 1;
        
        if ($days < 1) $days = 1;
        
        $pricePerDay = $vehicle->price_per_day;
        $vehicleSubtotal = $pricePerDay * $days;
        
        $selectedAddons = $request->input('addons', []);
        $addonsPrice = 0;
        $addonsDetails = [];
        
        foreach ($selectedAddons as $addonKey) {
            if (isset(Rental::$addonOptions[$addonKey])) {
                $addon = Rental::$addonOptions[$addonKey];
                // All add-ons are flat rate
                $addonPrice = $addon['price'];
                $addonsPrice += $addonPrice;
                $addonsDetails[$addonKey] = [
                    'name' => $addon['name'],
                    'price' => $addonPrice,
                ];
            }
        }
        
        $subtotal = $vehicleSubtotal + $addonsPrice;
        $taxAmount = round($subtotal * 0.12, 2);
        $totalPrice = round($subtotal + $taxAmount, 2);
        
        return response()->json([
            'days' => $days,
            'vehicle_subtotal' => $vehicleSubtotal,
            'addons_price' => $addonsPrice,
            'addons_details' => $addonsDetails,
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total_price' => $totalPrice,
            'price_per_day' => $pricePerDay,
        ]);
    }
}

