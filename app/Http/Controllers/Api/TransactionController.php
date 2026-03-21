<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'rental_id' => 'nullable|exists:rentals,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'nullable|string|max:100',
            'status' => 'nullable|in:pending,completed,failed',
            'notes' => 'nullable|string'
        ]);

        $tx = Transaction::create(array_merge($data, ['status' => $data['status'] ?? 'pending']));

        return response()->json($tx, 201);
    }
}
