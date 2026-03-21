<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GpsPosition;
use App\Models\Vehicle;

class GpsPositionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'speed' => 'nullable|numeric',
            'heading' => 'nullable|integer',
            'recorded_at' => 'nullable|date'
        ]);

        $pos = GpsPosition::create($data);

        return response()->json(['success' => true, 'id' => $pos->id], 201);
    }
}
