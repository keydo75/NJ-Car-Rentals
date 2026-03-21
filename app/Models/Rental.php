<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rental extends Model
{
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'addons' => 'array',
        'terms_accepted' => 'boolean',
        'terms_accepted_at' => 'datetime',
    ];
    
    use HasFactory, SoftDeletes;

    // Add-on options with prices (can also be stored in config/database)
    public static $addonOptions = [
        'additional_driver' => [
            'name' => 'Additional Driver',
            'price' => 200, // flat rate
            'icon' => 'bi-person-plus',
            'description' => 'Add an extra authorized driver at no extra cost'
        ],
        'child_seat' => [
            'name' => 'Child Seat',
            'price' => 100, // flat rate
            'icon' => 'bi-baby',
            'description' => 'Safety-certified child seat for kids'
        ],
    ];

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'start_date',
        'end_date',
        'days',
        'total_price',
        'status',
        'pickup_location',
        'dropoff_location',
        'pickup_lat',
        'pickup_lon',
        'dropoff_lat',
        'dropoff_lon',
        'notes',
        'addons',
        'addons_price',
        'subtotal',
        'tax_amount',
        'terms_accepted',
        'terms_accepted_at',
    ];

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}