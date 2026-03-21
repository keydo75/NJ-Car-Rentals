<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        // Fetch messages by inquiry or rental
        $messages = Message::query();

        if ($request->has('inquiry_id')) {
            $messages->where('inquiry_id', $request->query('inquiry_id'));
        }
        if ($request->has('rental_id')) {
            $messages->where('rental_id', $request->query('rental_id'));
        }

        return response()->json($messages->orderBy('created_at')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'staff_id' => 'nullable|exists:users,id',
            'inquiry_id' => 'nullable|exists:inquiries,id',
            'rental_id' => 'nullable|exists:rentals,id',
            'sender' => 'required|in:user,staff,system',
            'message' => 'required|string|max:5000'
        ]);

        $msg = Message::create($data);

        return response()->json($msg, 201);
    }
}
