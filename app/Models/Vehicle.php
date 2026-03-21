<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'make',
        'model',
        'year',
        'plate_number',
        'price_per_day',
        'sale_price',
        'status',
        'transmission',
        'seats',
        'fuel_type',
        'features',
        'description',
        'image_url',
        'gallery_images',
        'image_path',
        'has_gps',
        'gps_enabled'
    ];

    protected $casts = [
        'features' => 'array',
        'gps_enabled' => 'boolean'
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function activeRental()
    {
        return $this->hasOne(Rental::class)->whereIn('status', ['confirmed', 'ongoing'])->where('end_date', '>=', now())->orderBy('end_date', 'asc');
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeForRent($query)
    {
        return $query->where('type', 'rental');
    }

    public function scopeForSale($query)
    {
        return $query->where('type', 'sale');
    }

    // Accessors for backward compatibility with blade templates
    public function getBrandAttribute()
    {
        return $this->make;
    }

    public function getNameAttribute()
    {
        return $this->year . ' ' . $this->make . ' ' . $this->model;
    }

    public function getImageUrlAttribute()
    {
        if (!empty($this->image_path)) {
            return asset($this->image_path);
        }

        $imageUrl = $this->attributes['image_url'] ?? null;
        if ($imageUrl) {
            // If this is a relative path (like images/...), convert to asset URL
            if (Str::startsWith($imageUrl, ['http', '/'])) {
                return $imageUrl;
            }
            return asset($imageUrl);
        }

        return asset('images/hero-vehicle.jpg');
    }

    // Method for backward compatibility with blade templates
    public function getImageUrl()
    {
        return $this->getImageUrlAttribute();
    }
}

