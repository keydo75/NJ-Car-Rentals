<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'rental_id', 'amount', 'method', 'status', 'notes'];

    public function user() {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function rental() {
        return $this->belongsTo(Rental::class);
    }
}
