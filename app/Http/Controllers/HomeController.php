<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch featured vehicles (latest 6 available vehicles)
$featuredVehicles = Vehicle::with(['rentals' => function($q) {
                $q->whereIn('status', ['pending', 'confirmed', 'ongoing'])
                  ->where('end_date', '>=', now())
                  ->orderBy('end_date', 'asc');
            }])->orderBy('created_at', 'desc')
            ->take(8)
            ->get()
            ->each(function ($vehicle) {
                $active = $vehicle->rentals->first();
                $vehicle->rented_until = $active ? $active->end_date->format('M d, Y') : null;
                $vehicle->rental_status = $active ? $active->status : null;
            });

        return view('welcome', compact('featuredVehicles'));
    }
}