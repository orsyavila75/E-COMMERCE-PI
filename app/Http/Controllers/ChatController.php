<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Get list of users who have chatted with current user OR are potential contacts
        // For simplicity: If Seller, get Customers who ordered. If Customer, get Sellers.
        // For now, let's just get all users except self to make it easy to test
        // In a real app, you'd filter this better.
        
        $contacts = User::where('id_user', '!=', $userId)
            ->where(function($query) {
                // Optional: Filter by role if needed, e.g. only show Sellers to Customers
            })
            ->get()
            ->map(function($user) use ($userId) {
                // Get last message
$lastMessage = Message::where(function($query) use ($userId) {
    $query->where('sender_id', $userId)->where('receiver_id', $userId);
})->latest()->first();


                $user->last_message = $lastMessage ? $lastMessage->message : 'Belum ada pesan';
                $user->last_message_time = $lastMessage ? $lastMessage->created_at : null;
                $user->unread_count = Message::where('sender_id', $user->id_user)
                    ->where('receiver_id', $userId)
                    ->where('is_read', false)
                    ->count();
                
                return $user;
            })
            ->sortByDesc('last_message_time'); // Sort by most recent interaction

        return view('main.chat', compact('contacts'));
    }

    public function getMessages($userId)
    {
        $myId = Auth::id();

        // Mark messages as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', $myId)
            ->update(['is_read' => true]);

        $messages = Message::where(function($q) use ($myId, $userId) {
            $q->where('sender_id', $myId)->where('receiver_id', $userId);
        })->orWhere(function($q) use ($myId, $userId) {
            $q->where('sender_id', $userId)->where('receiver_id', $myId);
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id_user',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json($message);
    }
}
