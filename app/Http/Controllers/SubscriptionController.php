<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:subscriptions,email',
        ]);

        $subscription = Subscription::create([
            'email' => $validated['email'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Log for visibility in development
        Log::info('New subscription created', ['email' => $subscription->email]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['message' => 'Thanks — you are subscribed.'], 201);
        }

        return back()->with('success', 'Thanks — you are subscribed.');
    }
}