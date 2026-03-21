<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Message;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
            'type' => 'required|in:rental,sale',
        ]);

        $inquiry = Inquiry::create([
            'user_id' => auth()->guard('customer')->id(),
            'vehicle_id' => $request->vehicle_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'type' => $request->type,
            'status' => 'pending',
        ]);

        // Create chat message for notification
        Message::create([
            'user_id' => auth()->guard('customer')->id(),
            'message' => "New " . ucfirst($request->type) . " inquiry: {$request->message} - Vehicle ID: {$request->vehicle_id}",
            'sender' => 'user',
            'read' => false
        ]);

        return redirect()->back()->with('success', 'Your inquiry has been submitted and sent to chat! Our team will respond soon.'); 
    }
}
