<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GpsPosition extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_id', 'latitude', 'longitude', 'speed', 'heading', 'recorded_at'];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }
}
