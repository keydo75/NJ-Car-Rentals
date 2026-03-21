<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'staff_id', 'inquiry_id', 'rental_id', 'sender', 'message', 'read'
    ];

    public function user() {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function staff() {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function inquiry() {
        return $this->belongsTo(Inquiry::class);
    }

    public function rental() {
        return $this->belongsTo(Rental::class);
    }
}
