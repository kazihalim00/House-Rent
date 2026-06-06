<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Show conversation list
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'Admin') {
            // Admin sees ALL conversations
            $conversations = Conversation::with(['tenant', 'messages'])
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            // Normal user sees only THEIR conversation
            $conversations = Conversation::with(['owner', 'messages'])
                ->where('tenant_id', $user->id)
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        return view('panel.pages.chat', compact('conversations', 'user'));
    }

    // Open a specific conversation
    public function show($id)
    {
        $user = Auth::user();

        $conversation = Conversation::with(['messages.user', 'tenant', 'owner'])
            ->findOrFail($id);

        // Security: only participants can open this chat
        if ($conversation->tenant_id !== $user->id && $conversation->owner_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $messages = $conversation
            ->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('panel.pages.chat_room', compact('conversation', 'messages', 'user'));
    }

    // User starts a new conversation with Admin
    public function startConversation()
    {
        $user = Auth::user();

        // Find the admin user
        $admin = User::where('role', 'Admin')->first();

        if (!$admin) {
            return redirect()->route('chat.index')->with('error', 'No admin found.');
        }

        // Check if conversation already exists — don't create duplicates
        $existing = Conversation::where('tenant_id', $user->id)
            ->where('owner_id', $admin->id)
            ->first();

        if ($existing) {
            return redirect()->route('chat.show', $existing->id);
        }

        // Create new conversation
        $conversation = Conversation::create([
            'tenant_id' => $user->id,
            'owner_id' => $admin->id,
        ]);

        return redirect()->route('chat.show', $conversation->id);
    }

    // Send a message
    public function send(Request $request, $conversationId)
    {
        $request->validate(['body' => 'required|string|max:1000']);

        $user = Auth::user();
        $conversation = Conversation::findOrFail($conversationId);

        // Security: only participants can send
        if ($conversation->tenant_id !== $user->id && $conversation->owner_id !== $user->id) {
            abort(403);
        }

        Message::create([
            'conversation_id' => $conversationId,
            'user_id' => $user->id,
            'body' => $request->body,
        ]);

        // Update conversation timestamp for sorting
        $conversation->touch();

        return redirect()->back();
    }

    // Polling — fetch new messages every 3 seconds
    public function fetch(Request $request, $conversationId)
    {
        $user = Auth::user();
        $lastId = $request->query('last_id', 0);

        $conversation = Conversation::findOrFail($conversationId);

        // Security check
        if ($conversation->tenant_id !== $user->id && $conversation->owner_id !== $user->id) {
            abort(403);
        }

        $messages = Message::with('user')
            ->where('conversation_id', $conversationId)
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'body' => $msg->body,
                    'user_id' => $msg->user_id,
                    'user_name' => $msg->user->name,
                    'created_at' => $msg->created_at->format('h:i A'),
                    'is_mine' => $msg->user_id === auth()->id(),
                ];
            });

        return response()->json($messages);
    }
}
