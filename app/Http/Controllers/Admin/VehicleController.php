<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::withTrashed()->paginate(15);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:rental,sale',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'plate_number' => 'required|string|max:255|unique:vehicles',
            'price_per_day' => 'required_if:type,rental|nullable|numeric|min:0',
            'sale_price' => 'required_if:type,sale|nullable|numeric|min:0',
            'status' => 'required|in:available,unavailable',
            'transmission' => 'required|in:manual,automatic',
            'seats' => 'required|integer|min:1|max:20',
            'fuel_type' => 'required|in:gasoline,diesel,electric,hybrid',
            'features' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5000',
            'has_gps' => 'boolean',
            'gps_enabled' => 'boolean',
        ]);

        $data = $request->all();

        // Handle features as array
        if ($request->has('features')) {
            $data['features'] = array_map('trim', explode(',', $request->features));
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/vehicles', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        Vehicle::create($data);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle created successfully.');
    }

    public function show(Vehicle $vehicle)
    {
        return view('admin.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'type' => 'required|in:rental,sale',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'plate_number' => 'required|string|max:255|unique:vehicles,plate_number,' . $vehicle->id,
            'price_per_day' => 'required_if:type,rental|nullable|numeric|min:0',
            'sale_price' => 'required_if:type,sale|nullable|numeric|min:0',
            'status' => 'required|in:available,unavailable',
            'transmission' => 'required|in:manual,automatic',
            'seats' => 'required|integer|min:1|max:20',
            'fuel_type' => 'required|in:gasoline,diesel,electric,hybrid',
            'features' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5000',
            'has_gps' => 'boolean',
            'gps_enabled' => 'boolean',
        ]);

        $data = $request->all();

        // Handle features as array
        if ($request->has('features')) {
            $data['features'] = array_map('trim', explode(',', $request->features));
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($vehicle->image_path && Storage::disk('public')->exists(str_replace('storage/', '', $vehicle->image_path))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $vehicle->image_path));
            }

            $path = $request->file('image')->store('images/vehicles', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        $vehicle->update($data);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle deleted successfully.');
    }

    public function restore($id)
    {
        $vehicle = Vehicle::withTrashed()->findOrFail($id);
        $vehicle->restore();
        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle restored successfully.');
    }

    public function forceDelete($id)
    {
        $vehicle = Vehicle::withTrashed()->findOrFail($id);

        // Delete image if exists
        if ($vehicle->image_path && Storage::disk('public')->exists(str_replace('storage/', '', $vehicle->image_path))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $vehicle->image_path));
        }

        $vehicle->forceDelete();
        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle permanently deleted.');
    }
}
