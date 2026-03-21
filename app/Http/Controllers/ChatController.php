<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Show the customer chat interface
     */
    public function customerChat()
    {
        $userId = Auth::guard('customer')->id();
        
        // Get all conversations (grouped by latest message)
        $conversations = Message::where('user_id', $userId)
            ->select('staff_id')
            ->distinct()
            ->with('staff')
            ->get()
            ->filter(function($conv) {
                return $conv->staff !== null;
            });
        
        // Get messages from any admin (staff_id not null)
        $messages = Message::where('user_id', $userId)
            ->whereNotNull('staff_id')
            ->orderBy('created_at', 'asc')
            ->get();
            
        // Get unread count
        $unreadCount = Message::where('user_id', $userId)
            ->whereNotNull('staff_id')
            ->where('read', false)
            ->count();
            
        return view('customer.chat', compact('messages', 'conversations', 'unreadCount'));
    }
    
    /**
     * Show the admin chat interface
     */
    public function adminChat()
    {
        // Get all customers who have chatted
        $conversations = Message::whereNotNull('user_id')
            ->select('user_id')
            ->distinct()
            ->with('user')
            ->get()
            ->filter(function($conv) {
                return $conv->user !== null;
            });
            
        // Get all unread messages
        $unreadCount = Message::whereNotNull('user_id')
            ->where('read', false)
            ->count();
            
        return view('admin.chat', compact('conversations', 'unreadCount'));
    }
    
    /**
     * Get messages for a specific conversation
     */
    public function getMessages(Request $request)
    {
        // Check if this is an admin request
        $isAdmin = auth()->guard('admin')->check() || auth()->guard('staff')->check();
        
        if ($isAdmin) {
            // Admin viewing messages from a specific user
            $userId = $request->user_id;
            if (!$userId) {
                return response()->json([]);
            }
            
            $messages = Message::where('user_id', $userId)
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function($msg) {
                    return [
                        'id' => $msg->id,
                        'message' => $msg->message,
                        'sender' => $msg->sender,
                        'created_at' => $msg->created_at->toIso8601String(),
                    ];
                });
            
            // Mark as read
            Message::where('user_id', $userId)
                ->where('read', false)
                ->update(['read' => true]);
                
            return response()->json($messages);
        } else {
            // Customer viewing their messages
            $userId = auth()->guard('customer')->id();
            
            $messages = Message::where('user_id', $userId)
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function($msg) {
                    return [
                        'id' => $msg->id,
                        'message' => $msg->message,
                        'sender' => $msg->sender,
                        'created_at' => $msg->created_at->toIso8601String(),
                    ];
                });
            
            // Mark staff messages as read
            Message::where('user_id', $userId)
                ->where('sender', 'staff')
                ->where('read', false)
                ->update(['read' => true]);
                
            return response()->json($messages);
        }
    }
    
    /**
     * Send a message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);
        
        $userId = Auth::guard('customer')->id();
        $staffId = Auth::guard('admin')->id();
        
        // If customer is logged in
        if ($userId) {
            $message = Message::create([
                'user_id' => $userId,
                'staff_id' => null, // Will be assigned by admin when responding
                'sender' => 'user',
                'message' => $request->message,
                'read' => false
            ]);
        }
        // If admin is logged in
        elseif ($staffId) {
            $message = Message::create([
                'user_id' => $request->user_id,
                'staff_id' => $staffId,
                'sender' => 'staff',
                'message' => $request->message,
                'read' => false
            ]);
        }
        
        return response()->json($message, 201);
    }
    
    /**
     * Get unread message count with notification details (for polling)
     */
    public function getUnreadCount(Request $request)
    {
        if (auth()->guard('admin')->check() || auth()->guard('staff')->check()) {
            $count = Message::whereNotNull('user_id')
                ->where('read', false)
                ->where('sender', 'user')
                ->count();
            
            return response()->json(['unread' => $count]);
        }
        
        $userId = auth()->guard('customer')->id();
        $count = Message::where('user_id', $userId)
            ->where('sender', 'staff')
            ->where('read', false)
            ->count();
            
        return response()->json(['unread' => $count]);
    }
}
